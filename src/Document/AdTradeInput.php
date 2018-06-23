<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 19:12
 */

namespace App\Document;

use App\Entity\Algorithm;
use App\Entity\AttrsInterface;
use App\Entity\AttrsTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Class AdBuyInput
 * @package App\Document
 * @MongoDB\InheritanceType("COLLECTION_PER_CLASS")
 */
class AdTradeInput implements AttrsInterface
{
    use AttrsTrait;
    /**
     * @var Algorithm
     */
    private $algorithm;
    /**
     * @var integer
     * @MongoDB\Field(type="int")
     */
    protected $ad_id;

    /**
     * @var float
     * @MongoDB\Field(type="string")
     */
    protected $price_step;

    /**
     * @return integer
     */
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * @param integer $ad_id
     */
    public function setAdId($ad_id)
    {
        $this->ad_id = $ad_id;
    }

    /**
     * @return float
     */
    public function getPriceStep()
    {
        return $this->price_step;
    }

    /**
     * @param float $price_step
     */
    public function setPriceStep($price_step)
    {
        $this->price_step = $price_step;
    }

    /**
     * @return Algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param Algorithm $algorithm
     * @return AdTradeInput
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
        return $this;
    }
}