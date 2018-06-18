<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use App\Document\Ad;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class UserAd
 * @package App\Document
 * @MongoDB\Document(collection="userAds")
 */
class UserAd extends Ad
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
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
    protected $account_details;    //: { payment method specific fields }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Ad
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * @param mixed $profile_id
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    /**
     * @return mixed
     */
    public function getPriceEquation()
    {
        return $this->price_equation;
    }

    /**
     * @param mixed $price_equation
     */
    public function setPriceEquation($price_equation)
    {
        $this->price_equation = $price_equation;
    }

    /**
     * @return mixed
     */
    public function getOpeningHours()
    {
        return $this->opening_hours;
    }

    /**
     * @param mixed $opening_hours
     */
    public function setOpeningHours($opening_hours)
    {
        $this->opening_hours = $opening_hours;
    }

    /**
     * @return mixed
     */
    public function getAccountInfo()
    {
        return $this->account_info;
    }

    /**
     * @param mixed $account_info
     */
    public function setAccountInfo($account_info)
    {
        $this->account_info = $account_info;
    }

    /**
     * @return mixed
     */
    public function getAccountDetails()
    {
        return $this->account_details;
    }

    /**
     * @param mixed $account_details
     */
    public function setAccountDetails($account_details)
    {
        $this->account_details = $account_details;
    }

}