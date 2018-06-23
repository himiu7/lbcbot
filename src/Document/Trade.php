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
    const TRADE_USER = 'user';
    const TRADE_SELL = 'sell';
    const TRADE_BUY = 'buy';
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
    private $countrycode;

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
                  . $this->countrycode
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
     * @return Trade
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * @return Trade
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
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
     * @return Trade
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
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
     * @return Trade
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * @param string $countrycode
     * @return Trade
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;
        return $this;
    }


}