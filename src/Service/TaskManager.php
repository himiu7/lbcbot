<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 18:03
 */

namespace App\Service;


use App\Api\LbcBundle\DataProvider;
use App\Document\Task;
use App\Document\Trade;
use App\Document\UserAd;
use App\Document\Ad;
use App\Entity\Algorithm;
use App\Entity\Profile as Profile;
use App\Document\Profile as AdProfile;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class TaskManager
{
    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var LoggerInterfacer
     */
    private $logger;
    /**
     * TaskManager constructor.
     * @param DocumentManager $dm
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(DocumentManager $dm, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->dm = $dm;
        $this->logger = $logger;
    }

    public function updateTrade(Trade $trade)
    {
        $listId = $trade->buildListId();

        $api = new DataProvider('sell', Ad::class);

        $ads = $api->getData([
            /*'key' => 'f987d4bac28c162ba1ed59d5431392ee',
            'secret' => 'faba61428f43afdbd02152d7595e5f6fa7d7f567acbf01dfb1cdd811fc9b3dae',*/
            'country' => 'Ukraine',
            'countrycode' => 'UA',
            //'page' => 2,
            'fields' => [
                'ad_id',
                'profile',
                'temp_price',
                'temp_price_usd',
                'currency'
            ]
        ]);
    }
    /**
     * @param Task $task
     */
    public function createTask(Task $task)
    {
        $this->logger->log(LogLevel::INFO, print_r($task, true));
        // TODO: create TASK
        die;
    }

    public function startTask()
    {

    }

    public function endTask()
    {

    }

    /**
     * @param Profile $profile
     * @return \App\Document\UserAd[]|void
     */
    public function getUserAds(Profile &$profile)
    {
        /** @var UserAd[] $ads */
        $ads = $this->dm->getRepository(UserAd::class)
            ->findBy([
                'profile_id' => $profile->getId()
            ]);

        if (empty($ads) && !$profile->getLastAdsUpdate()) {

            return $this->updateUserAds($profile);
        }

        return $ads;
    }

    /**
     * @param Profile $profile
     * @return \App\Document\UserAd[]
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @throws \Exception
     * @return UserAd[]
     */
    public function updateUserAds(Profile &$profile)
    {
        $this->dm->createQueryBuilder(UserAd::class)
            ->remove()
            ->field('profile_id')->equals($profile->getId())
            ->getQuery()
            ->execute();

        $api = new DataProvider('user', UserAd::class, ['profile' => AdProfile::class]);

        /** @var UserAd[] $ads */
        $ads = $api->getData([
            'key' => $profile->getKey(),
            'secret' => $profile->getSecret(),
        ]);

        foreach ($ads as $ad) {
            $ad->setProfileId($profile->getId());
            $this->dm->persist($ad);
        }

        $this->dm->flush();

        $profile->setLastAdsUpdate(new \DateTime());
        $this->em->persist($profile);
        $this->em->flush();

        return $ads;
    }
    /**
     * @param string $name
     * @return Algorithm
     */
    public function getAlgorithm(string $name = null)
    {
        if (!$name) {
            return null;
        }

        $alg = $this->em->getRepository(Algorithm::class)
            ->findOneBy([
                'name' => $name
            ]);

        return $alg;
    }

    public function initList()
    {

    }

}