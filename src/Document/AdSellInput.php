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
 * Class AdSellInput
 * @package App\Document
 * @MongoDB\EmbeddedDocument()
 */
class AdSellInput extends AdTradeInput
{
    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    private $min_price_limit;

    /**
     * @return float
     */
    public function getMinPriceLimit()
    {
        return $this->min_price_limit;
    }

    /**
     * @param float $min_price_limit
     * @return AdSellInput
     */
    public function setMinPriceLimit($min_price_limit)
    {
        $this->min_price_limit = $min_price_limit;
        return $this;
    }
}