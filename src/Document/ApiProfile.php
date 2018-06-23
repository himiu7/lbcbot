<?php
/**
 * Created by PhpStorm.
 * User: himius
 * Date: 22.06.2018
 * Time: 15:58
 */

namespace App\Document;

use App\Api\LbcBundle\ApiProfileInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class ApiProfile
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class ApiProfile implements ApiProfileInterface
{
    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    private $profile_id;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $key;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $secret;

    /**
     * @var \MongoTimestamp
     * @MongoDB\Field(type="timestamp")
     */
    private $last_ads_update;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return ApiProfile
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @return ApiProfile
     */
    public function setSecret(string $secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return \MongoTimestamp
     */
    public function getLastAdsUpdate()
    {
        return $this->last_ads_update;
    }

    /**
     * @param \DateTime $last_ads_update
     * @return ApiProfile
     */
    public function setLastAdsUpdate(\DateTime $last_ads_update)
    {
        $this->last_ads_update = new \MongoTimestamp($last_ads_update->getTimestamp());

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->profile_id;
    }

    /**
     * @param int $id
     * @return ApiProfile
     */
    public function setId($id)
    {
        $this->profile_id = $id;
        return $this;
    }
}