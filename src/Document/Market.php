<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use App\Document\Ad;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Market
 * @package App\Document
 * @MongoDB\Document(collection="markets")
 */
class Market
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @MongoDB\Index()
     */
    protected $list_id;
    /**
     * @MongoDB\Field(type="timestamp")
     */
    protected $last_update;

    /**
     * @var TradeAd[]
     * @MongoDB\EmbedMany(targetDocument="Ad")
     */
    private $ads = [];

    /**
     * @var Trade
     * @MongoDB\EmbedOne(targetDocument="Trade")
     */
    private $provider;

    /**
     * TradeAd constructor.
     */
    public function __construct()
    {
        $this->ads = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param string $list_id
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }

    /**
     * @return int Timestamp
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param integer $last_update Timestamp
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }

    /**
     * @return TradeAd[]
     */
    public function getAds()
    {
        return $this->ads;
    }

    /**
     * @param TradeAd[] $ads
     */
    public function setAds($ads)
    {
        $this->ads = $ads;
    }

    /**
     * @return Trade
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param Trade $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}