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
 * Class AdBuyInput
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class AdBuyInput extends AdTradeInput
{
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $max_price_limit;

    /**
     * @return float
     */
    public function getMaxPriceLimit()
    {
        return $this->max_price_limit;
    }

    /**
     * @param float $max_price_limit
     * @return AdBuyInput
     */
    public function setMaxPriceLimit($max_price_limit)
    {
        $this->max_price_limit = $max_price_limit;
        return $this;
    }
}