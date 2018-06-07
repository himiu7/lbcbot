<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use App\LbcBundle\Document\Ad;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class UserAd
 * @package App\Document
 * @MongoDB\Document(collection="userAds")
 */
class UserAd extends Ad
{
    /**
     * @MongoDB\Field(type="int")
     */
    protected $profile_id;
    /**
     * @MongoDB\Field(type="string")
     */
    protected $price_equation;    //: string,
    /**
     * @MongoDB\Field(type="string")
     */
    protected $opening_hours;     //: "null" or "[[sun_start, sun_end], [mon_start, mon_end], [tue_start, tue_end], [wed_start, wed_end], [thu_start, thu_end], [fri_start, fri_end], [sat_start, sat_end]",
    /**
     * @MongoDB\Field(type="string")
     */
    protected $account_info;      //: string,
    /**
     * @MongoDB\EmbedOne()
     */
    protected $account_details;   //: { payment method specific fields }
}