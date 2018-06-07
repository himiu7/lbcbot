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
 * @MongoDB\Document()
 */
class Ad
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @MongoDB\Field(type="int")
     */
    protected $ad_id; //: primary key of the ad,
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
     * @MongoDB\Field(type="string")
     */
    protected $currency; //: three letter string,
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
     * @MongoDB\Field(type="float")
     */
    protected $temp_price_usd; //: current price per BTC in USD,
    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $floating; //: boolean if LOCAL_SELL,
    /**
     * @MongoDB\EmbedOne(targetDocument="Profile")
     */
    protected $profile; //: null or Proofile
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
}

/**
 * Class Profile
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class Profile
{
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
}


