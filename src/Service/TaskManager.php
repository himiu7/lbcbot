<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 18:03
 */

namespace App\Service;


use App\Api\LbcBundle\ApiClient;
use App\Api\LbcBundle\ApiProfileInterface;
use App\Api\LbcBundle\DataProvider;
use App\Document\ApiProfile;
use App\Document\Market;
use App\Document\Task;
use App\Document\Trade;
use App\Document\TradeAd;
use App\Document\UserAd;
use App\Entity\Algorithm;
use App\Entity\Profile as Profile;
use App\Document\Profile as AdProfile;
use App\Model\TaskInput;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\RequestException;
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

    private static $exchRates = [
        'usd_uah' => 25.06,
        'uah_usd' => 1 / 25.06
    ];
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

    /**
     * @param TaskInput $task
     * @throws \Exception
     * @return Task
     */
    public function createTask(TaskInput $task)
    {
        $doc = new Task();

        // copy attrs
        $attrs = $task->getAttrs([
            'title',
            'profile_id',
            'command',
            'params'
        ]);
		$doc
            ->setAttrs($attrs, [
                'params' => $task->getAlgorithm()->getInputClass()
            ])
            ->setStatus(Task::STATUS_NEW);

        // prepare list
        $type = $task->getAd()->getTradeType() == 'ONLINE_BUY' ? Trade::TRADE_SELL : Trade::TRADE_BUY;

        $list = (new Trade())
            ->setType($type)
            ->setCountry($task->getAd()->getLocationString())
            ->setCountrycode($task->getAd()->getCountrycode())
            ->setCurrency($task->getAd()->getCurrency());

        if (!$this->initList($task->getAd()->getAdId(), $list)) {
            throw new \Exception('Объявление не активно');
        }

        $doc->setListId($list->buildListId());

        $doc->setMarket($this->updateTrade($list));

        $doc->setApi((new ApiProfile())
                ->setId($task->getProfileId())
                ->setSecret($task->getProfile()->getSecret())
                ->setKey($task->getProfile()->getKey())
            );

        $this->dm->persist($doc);
        $this->dm->flush();

        return $doc;
    }

    public function startTask()
    {

    }

    public function endTask()
    {

    }

    /**
     * @param ApiProfileInterface $profile
     * @param int $adId
     * @param float $koef
     * @return bool
     */
    public function changeEquation(ApiProfileInterface $profile, int $adId, float $koef)
    {
        $api = ApiClient::factory([
            'key' => $profile->getKey(),
            'secret' => $profile->getSecret()
        ]);

        try {
            $api->adUpdateEquation([
                'ad_id' => $adId,
                'price_equation' => sprintf("btc_in_usd*USD_in_UAH*%f", $koef)
            ]);
        } catch (RequestException $e) {
            return false;
        }

        return true;
    }
    /**
     * @param Profile $profile
     * @param array $filter
     * @return \App\Document\UserAd[]|void
     */
    public function getUserAds(Profile $profile, $filter=[])
    {
        $filter = array_merge($filter, [
            'profile_id' => $profile->getId()
        ]);

        /** @var UserAd[] $ads */
        $ads = $this->dm->getRepository(UserAd::class)
            ->findBy($filter);

        if (empty($ads)
            && (!$profile->getLastAdsUpdate()
                || ($filter['force'] ?? false))
        ) {

            return $this->updateUserAds($profile);
        }

        return $ads;
    }

    /**
     * @param ApiProfileInterface $profile
     * @param \MongoTimestamp $lastUpdate
     * @return \App\Document\UserAd[]
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @throws \Exception
     */
    public function refreshUserAds(ApiProfileInterface &$profile, \MongoTimestamp $lastUpdate = null)
    {
        if (!$lastUpdate) {
            $lastUpdate = new \MongoTimestamp();
        }
        $this->dm->createQueryBuilder(UserAd::class)
            ->remove()
            ->field('profile_id')->equals($profile->getId())
            ->getQuery()
            ->execute()
        ;

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

        $this->dm->createQueryBuilder(Task::class)
            ->updateMany()
            ->field('api.last_ads_update')->set($profile->getLastAdsUpdate())
            ->field('api.last_ads_update')->lt($lastUpdate)
            ->field('profile_id')->equals($profile->getId())
            ->getQuery()
            ->execute()
        ;

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

        $ads = $this->refreshUserAds($profile);

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
    /**
     * @param int $adId
     * @param Trade $trade
     * @return bool
     */
    public function initList($adId, Trade &$trade)
    {
        $api = new DataProvider($trade->getType(), TradeAd::class);

        $page = 1;

        do {
            $ads = $api->getData([
                'country' => $trade->getCountry(),
                'countrycode' => $trade->getCountrycode(),
                'page' => $page,
                'fields' => [
                    'ad_id'
                ]
            ]);

            $ok = $ads->exists(function($key, TradeAd $el) use ($adId) {

                return $el->getAdId() == $adId;
            });

            if ($ok) {
                break;
            }

            $next = $page;

            if ($pager = $api->getPagination()) {
                $next = $pager->getNext() ?? false;
            }

            $page++;
            // todo Debug: < 5
            if ($page > 5) {
                break;
            }
        } while ($next == $page);

        if ($ok) {
            $trade->setPage($page);
        }

        return $ok;
    }

    /**
     * @param Trade $trade
     * @return Market
     */
    public function updateTrade(Trade $trade)
    {
        $listId = $trade->buildListId();

        $api = new DataProvider($trade->getType(), TradeAd::class, [
            'profile' => AdProfile::class
        ]);

        $ads = $api->getData([
            'country' => $trade->getCountry(),
            'countrycode' => $trade->getCountrycode(),
            'page' => $trade->getPage(),
            'fields' => [
                'ad_id',
                'temp_price_usd',
                'temp_price',
                'min_amount',
                'max_amount',
                'max_amount_available',
                'profile',
                'currency'
            ]
        ]);
        /** @var Market $market */
        $market = $this->dm->getRepository(Market::class)
            ->findOneBy([
                'list_id' => $listId
            ]);

        if (!$market) {
            $market = (new Market())
                ->setListId($listId)
                ->setProvider($trade);
        }

        $market
            ->setAds($ads)
            ->setLastUpdate(new \MongoTimestamp());

        $this->dm->persist($market);
        $this->dm->flush();

        return $market;
    }

    /**
     * @param float $price
     * @param string $from
     * @param string $to
     * @return float
     * @throws \Exception
     */
    public function convert(float $price, string $from='USD', string $to='UAH')
    {
        $curr = strtolower($from.'_'.$to);

        if (!isset(self::$exchRates[$curr])) {
            throw new \Exception(sprintf("Currency Exchange from %s to %s not exists", $from, $to));
        }

        return $price * self::$exchRates[$curr];
    }
}