<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 20:31
 */

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * Class Ad
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class Ad extends TradeAd
{
    /**
     * @MongoDB\Field(type="boolean")
    */
    protected $visible; //: boolean,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $hidden_by_opening_hours; //: boolean,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $location_string; //: human-readable location identifier string,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $countrycode; //: countrycode string, two letters,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $city; //: city name,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $trade_type; //: string, often one of LOCAL_SELL, LOCAL_BUY, ONLINE_SELL, ONLINE_BUY,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $online_provider; //: payment method string e.g. NATIONAL_BANK,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $first_time_limit_btc; //: string representation of a decimal or null,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $volume_coefficient_btc; //: string repr of a decimal,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $sms_verification_required; //: boolean
    /**
     * @MongoDB\Field(type="string")
     */
    protected $reference_type; //: string, e.g. SHORT,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $display_reference; //: boolean,
    /**
     * @MongoDB\Field(type="float")
     */
    protected $lat; //: float,
    /**
     * @MongoDB\Field(type="float")
     */
    protected $lon; //: float,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $min_amount; //: string repr of a decimal or null,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $max_amount; //: string repr of a decimal or null,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $max_amount_available; //: string repr of a decimal or null,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $limit_to_fiat_amounts; //: protected "5,10,20",
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $floating; //: boolean if LOCAL_SELL,
    /**
     * @MongoDB\Field(type="int")
     */
    protected $require_feedback_score; //: 50,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $require_trade_volume; //: null,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $require_trusted_by_advertiser; //: boolean,
    /**
     * @MongoDB\Field(type="int")
     */
    protected $payment_window_minutes; //: 30,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $bank_name; //: string,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $track_max_amount; //: boolean,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $atm_model; //: string or null

    /**
     * @return mixed
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param mixed $visible
     * @return Ad
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHiddenByOpeningHours()
    {
        return $this->hidden_by_opening_hours;
    }

    /**
     * @param mixed $hidden_by_opening_hours
     * @return Ad
     */
    public function setHiddenByOpeningHours($hidden_by_opening_hours)
    {
        $this->hidden_by_opening_hours = $hidden_by_opening_hours;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationString()
    {
        return $this->location_string;
    }

    /**
     * @param mixed $location_string
     * @return Ad
     */
    public function setLocationString($location_string)
    {
        $this->location_string = $location_string;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * @param mixed $countrycode
     * @return Ad
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Ad
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTradeType()
    {
        return $this->trade_type;
    }

    /**
     * @param mixed $trade_type
     * @return Ad
     */
    public function setTradeType($trade_type)
    {
        $this->trade_type = $trade_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnlineProvider()
    {
        return $this->online_provider;
    }

    /**
     * @param mixed $online_provider
     * @return Ad
     */
    public function setOnlineProvider($online_provider)
    {
        $this->online_provider = $online_provider;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstTimeLimitBtc()
    {
        return $this->first_time_limit_btc;
    }

    /**
     * @param mixed $first_time_limit_btc
     * @return Ad
     */
    public function setFirstTimeLimitBtc($first_time_limit_btc)
    {
        $this->first_time_limit_btc = $first_time_limit_btc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVolumeCoefficientBtc()
    {
        return $this->volume_coefficient_btc;
    }

    /**
     * @param mixed $volume_coefficient_btc
     * @return Ad
     */
    public function setVolumeCoefficientBtc($volume_coefficient_btc)
    {
        $this->volume_coefficient_btc = $volume_coefficient_btc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmsVerificationRequired()
    {
        return $this->sms_verification_required;
    }

    /**
     * @param mixed $sms_verification_required
     * @return Ad
     */
    public function setSmsVerificationRequired($sms_verification_required)
    {
        $this->sms_verification_required = $sms_verification_required;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferenceType()
    {
        return $this->reference_type;
    }

    /**
     * @param mixed $reference_type
     * @return Ad
     */
    public function setReferenceType($reference_type)
    {
        $this->reference_type = $reference_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayReference()
    {
        return $this->display_reference;
    }

    /**
     * @param mixed $display_reference
     * @return Ad
     */
    public function setDisplayReference($display_reference)
    {
        $this->display_reference = $display_reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     * @return Ad
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param mixed $lon
     * @return Ad
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinAmount()
    {
        return $this->min_amount;
    }

    /**
     * @param mixed $min_amount
     * @return Ad
     */
    public function setMinAmount($min_amount)
    {
        $this->min_amount = $min_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxAmount()
    {
        return $this->max_amount;
    }

    /**
     * @param mixed $max_amount
     * @return Ad
     */
    public function setMaxAmount($max_amount)
    {
        $this->max_amount = $max_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxAmountAvailable()
    {
        return $this->max_amount_available;
    }

    /**
     * @param mixed $max_amount_available
     * @return Ad
     */
    public function setMaxAmountAvailable($max_amount_available)
    {
        $this->max_amount_available = $max_amount_available;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimitToFiatAmounts()
    {
        return $this->limit_to_fiat_amounts;
    }

    /**
     * @param mixed $limit_to_fiat_amounts
     * @return Ad
     */
    public function setLimitToFiatAmounts($limit_to_fiat_amounts)
    {
        $this->limit_to_fiat_amounts = $limit_to_fiat_amounts;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFloating()
    {
        return $this->floating;
    }

    /**
     * @param mixed $floating
     * @return Ad
     */
    public function setFloating($floating)
    {
        $this->floating = $floating;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequireFeedbackScore()
    {
        return $this->require_feedback_score;
    }

    /**
     * @param mixed $require_feedback_score
     * @return Ad
     */
    public function setRequireFeedbackScore($require_feedback_score)
    {
        $this->require_feedback_score = $require_feedback_score;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequireTradeVolume()
    {
        return $this->require_trade_volume;
    }

    /**
     * @param mixed $require_trade_volume
     * @return Ad
     */
    public function setRequireTradeVolume($require_trade_volume)
    {
        $this->require_trade_volume = $require_trade_volume;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequireTrustedByAdvertiser()
    {
        return $this->require_trusted_by_advertiser;
    }

    /**
     * @param mixed $require_trusted_by_advertiser
     * @return Ad
     */
    public function setRequireTrustedByAdvertiser($require_trusted_by_advertiser)
    {
        $this->require_trusted_by_advertiser = $require_trusted_by_advertiser;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentWindowMinutes()
    {
        return $this->payment_window_minutes;
    }

    /**
     * @param mixed $payment_window_minutes
     * @return Ad
     */
    public function setPaymentWindowMinutes($payment_window_minutes)
    {
        $this->payment_window_minutes = $payment_window_minutes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * @param mixed $bank_name
     * @return Ad
     */
    public function setBankName($bank_name)
    {
        $this->bank_name = $bank_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrackMaxAmount()
    {
        return $this->track_max_amount;
    }

    /**
     * @param mixed $track_max_amount
     * @return Ad
     */
    public function setTrackMaxAmount($track_max_amount)
    {
        $this->track_max_amount = $track_max_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAtmModel()
    {
        return $this->atm_model;
    }

    /**
     * @param mixed $atm_model
     * @return Ad
     */
    public function setAtmModel($atm_model)
    {
        $this->atm_model = $atm_model;
        return $this;
    }
}

