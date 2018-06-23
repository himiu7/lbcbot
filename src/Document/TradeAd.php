<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use App\Document\Ad;
use App\Entity\AttrsInterface;
use App\Entity\AttrsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class TradeAd
 * @package App\Document
 * @MongoDB\InheritanceType("COLLECTION_PER_CLASS")
 * @MongoDB\EmbeddedDocument()
 */
class TradeAd implements AttrsInterface
{
    use AttrsTrait;
    /**
     * @var int
     * @MongoDB\Field(type="int")
     * @MongoDB\Index()
     */
    protected $ad_id; //: primary key of the ad,
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $currency; //: three letter string,
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $temp_price_usd; //: current price per BTC in USD,
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $temp_price; //: current price,
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $min_amount; //: string repr of a decimal or null,
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $max_amount; //: string repr of a decimal or null,
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $max_amount_available; //: string repr of a decimal or null,

    /**
     * @var Profile
     * @MongoDB\EmbedOne(targetDocument="Profile")
     */
    protected $profile;

    /**
     * @return mixed
     */
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * @param mixed $ad_id
     * @return TradeAd
     */
    public function setAdId($ad_id)
    {
        $this->ad_id = $ad_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return TradeAd
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempPriceUsd()
    {
        return $this->temp_price_usd;
    }

    /**
     * @param mixed $temp_price_usd
     * @return TradeAd
     */
    public function setTempPriceUsd($temp_price_usd)
    {
        $this->temp_price_usd = $temp_price_usd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempPrice()
    {
        return $this->temp_price;
    }

    /**
     * @param mixed $temp_price
     * @return TradeAd
     */
    public function setTempPrice($temp_price)
    {
        $this->temp_price = $temp_price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     * @return TradeAd
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinAmount()
    {
        return $this->min_amount;
    }

    /**
     * @param float $min_amount
     * @return TradeAd
     */
    public function setMinAmount($min_amount)
    {
        $this->min_amount = $min_amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxAmount()
    {
        return $this->max_amount;
    }

    /**
     * @param float $max_amount
     * @return TradeAd
     */
    public function setMaxAmount($max_amount)
    {
        $this->max_amount = $max_amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxAmountAvailable()
    {
        return $this->max_amount_available;
    }

    /**
     * @param float $max_amount_available
     * @return TradeAd
     */
    public function setMaxAmountAvailable($max_amount_available)
    {
        $this->max_amount_available = $max_amount_available;
        return $this;
    }
}

/**
 * Class Profile
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class Profile implements AttrsInterface
{
    use AttrsTrait;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $username; //: advertisement owner's profile username,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $name; //: username, trade count and feedback score combined,
    /**
     * @MongoDB\Field(type="date")
     */
    protected $last_online; //: user last seen, ISO formatted date,
    /**
     * @MongoDB\Field(type="int")
     */
    protected $trade_count; //: number of trades for user,
    /**
     * @MongoDB\Field(type="int")
     */
    protected $feedback_score; //: int

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Profile
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastOnline()
    {
        return $this->last_online;
    }

    /**
     * @param mixed $last_online
     * @return Profile
     */
    public function setLastOnline($last_online)
    {
        $this->last_online = $last_online;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTradeCount()
    {
        return $this->trade_count;
    }

    /**
     * @param mixed $trade_count
     * @return Profile
     */
    public function setTradeCount($trade_count)
    {
        $this->trade_count = $trade_count;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeedbackScore()
    {
        return $this->feedback_score;
    }

    /**
     * @param mixed $feedback_score
     * @return Profile
     */
    public function setFeedbackScore($feedback_score)
    {
        $this->feedback_score = $feedback_score;
        return $this;
    }
}
