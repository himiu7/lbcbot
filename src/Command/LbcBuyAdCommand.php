<?php

namespace App\Command;

use App\Document\AdBuyInput;
use App\Document\AdTradeResult;
use App\Document\Task;
use App\Document\Market;
use App\Document\Trade;
use App\Document\TradeAd;
use App\Document\UserAd;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LbcBuyAdCommand extends LbcTaskCommand
{
    protected static $defaultName = 'lbc:buy-ad';

    protected function configure()
    {
        $this
            ->setDescription('Buy Ad Command')
            ->addArgument('id', InputArgument::REQUIRED, 'Task #ID')
            ->addOption('update', null, InputOption::VALUE_NONE, 'Update or not user ads list when the ad has been updated')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');

        if (!$id) {
            $io->error('ID is required');
            return;
        }

        /** @var Task $task */
        $task = $this->dm->getRepository(Task::class)
            ->find($id);
        if (!$task) {
            $io->error(sprintf("Task #< %s ># Not Found", $id));
            return;
        }

        $task
            ->setStatus(Task::STATUS_ACTIVE)
            ->setLastStart(new \MongoTimestamp());

        $qb = $this->dm->createQueryBuilder(Task::class);
        $qb
            ->updateOne()
            ->field('status')->set($task->getStatus())
            ->field('last_start')->set($task->getLastStart())
            ->field('id')->equals($task->getId());

        /** @var AdBuyInput $params */
        $params = $task->getParams();

        /** @var AdTradeResult $result */
        $result = new AdTradeResult();
        $result->setCreatedAt(new \MongoTimestamp());

        /** @var Market $market */
        $market = $task->getMarket();

        try {
            if (!$market || !$market->getAds()) {
                throw new LbcTaskException('Market is not linked or empty');
            }

            $now = time();
            $lastUpdate = new \MongoTimestamp($now - $task->getInterval());

            // update market
            if ($market->getLastUpdate()->sec < $lastUpdate->sec) {
                // TODO uncommenet
                /*$market = $this->tm->updateTrade($market->getProvider());
                $this->dm->persist($market);
                $task->setMarket($market);*/

                $io->note(date('M,j h:m:s', $lastUpdate->sec));
            }

            // update user ads
            $api = $task->getApi();

            if (!$api->getLastAdsUpdate()
                || $api->getLastAdsUpdate() < $lastUpdate
            ) {
                $this->tm->refreshUserAds($api, $lastUpdate);
                $task->setApi($api);
                $io->note('* User Ads *');
            }
            // check position
            $pos = ($market->getProvider()->getPage() - 1) * 50;

            /** @var ArrayCollection $ad */
            $ad = $market->getAds()->filter(
                function (TradeAd $el) use ($params) {

                    return $el->getAdId() == $params->getAdId();
                });

            if (!$ad->count()) {
                throw new LbcTaskException('Ad is NOT ACTIVE');
            } else {
                // find competitors
                $_len = 5;
                $_pos = $ad->key() - $_len;

                if ($_pos < 0) {
                    $_len += $_pos;
                    $_pos = 0;
                }
                $result->setRivals($market->getAds()->slice($_pos, $_len));
                // position
                $pos += $ad->key();
                $result->setPosition($pos);
                /** @var UserAd $userAd */
                $userAd = $this->dm->getRepository(UserAd::class)
                    ->findOneBy([
                        'ad_id' => $params->getAdId()
                    ]);

                // optimize 'user ad update step'
                /** @var AdTradeResult $prevResult */
                $prevResult = $task->getCurrResult();

                $result->setTmpPrice($userAd->getTempPrice());

                if (!$prevResult) {
                    $koef = $result->parseEquation($userAd->getPriceEquation());
                    $result->setChange(0);
                } else {
                    $koef = $prevResult->getKoef();
                    $result->setChange($result->getTmpPrice() - $prevResult->getTmpPrice());
                }

                if ($koef) {
                    // TODO extend 'stop' Conditions
                    if ($pos > 1
                        && $userAd->getTempPrice() < $params->getMaxPriceLimit()
                    ) {
                        $koef += $params->getPriceStep();
                        $result->setKoef($koef);
                        $this->tm->changeEquation($api, $params->getAdId(), $koef);
                        // TODO test if the User Ads update required (add OPTION --update)
                        if ($input->getOption('update')) {
                            $this->tm->refreshUserAds($api, $lastUpdate);
                            $task->setApi($api);
                        }
                    }
                }
            }

            $result
                ->setCreatedAt(new \DateTime())
                ->setTask($task)
            ;

            $this->dm->persist($result);

            $task
                ->addResult($result)
                ->setCurrResult($result)
                ->setNextStart(new \MongoTimestamp(time() + $task->getInterval()))
                ->setStatus(Task::STATUS_WAIT)
            ;

            $this->dm->persist($task);
            $this->dm->flush();
        } catch (LbcTaskException $e) {

            $task->setStatus(Task::STATUS_ERROR);

            $result->setStatus($e->getMessage());
            $task->addResult($result);

            $this->dm->persist($result);
            $this->dm->persist($task);
            $this->dm->flush();

            $io->error($e->getMessage());
            return;
        }

        $io->success('Ok');
    }
}
