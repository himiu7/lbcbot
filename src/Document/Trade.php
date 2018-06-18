<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 19:12
 */

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Trade
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class Trade
{
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $country;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $currency;

    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    private $page;

    /**
     * @return string
     */
    public function buildListId()
    {
        return md5(
            strtolower(
                  $this->type
                  . $this->country
                  . $this->currency
                  . $this->page
            ));
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

}