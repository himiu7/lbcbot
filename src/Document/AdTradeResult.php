<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 19:13
 */

namespace App\Document;

use App\Entity\AttrsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class AdTradeResult
 * @package App\Document
 * @MongoDB\Document(collection="taskResults")
 */
class AdTradeResult
{
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @var Task
     * @MongoDB\ReferenceOne(targetDocument="Task")
     */
    protected $task;
    /**
     * @var \DateTime
     * @MongoDB\Field(type="date")
     */
    protected $created_at;
    /**
     * @var integer
     * @MongoDB\Field(type="int")
     */
    protected $position;
    /**
     * @var TradeAd[]
     * @MongoDB\EmbedMany(targetDocument="Ad")
     */
    protected $rivals;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $status;
    /**
     * @var float
     * @MongoDB\Field(type="float")
     */
    protected $koef;
    /**
     * @var float
     * @MongoDB\Field(type="float")
     */
    protected $tmp_price;
    /**
     * @var float
     * @MongoDB\Field(type="float")
     */
    protected $change;

    /**
     * AdTradeResult constructor.
     */
    public function __construct()
    {
        $this->rivals = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AdTradeResult
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param Task $task
     * @return AdTradeResult
     */
    public function setTask($task)
    {
        $this->task = $task;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     * @return AdTradeResult
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return AdTradeResult
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return TradeAd[]
     */
    public function getRivals()
    {
        return $this->rivals;
    }

    /**
     * @param TradeAd[] $rivals
     * @return AdTradeResult
     */
    public function setRivals($rivals)
    {
        $this->rivals = $rivals;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return AdTradeResult
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param TradeAd $rival
     * @return AdTradeResult
     */
    public function addRival(TradeAd $rival): self
    {
        if (!$this->rivals->contains($rival)) {
            $this->rivals[] = $rival;
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getKoef()
    {
        return $this->koef;
    }

    /**
     * @param float $koef
     * @return AdTradeResult
     */
    public function setKoef($koef)
    {
        $this->koef = $koef;
        return $this;
    }

    /**
     * @return float
     */
    public function getTmpPrice()
    {
        return $this->tmp_price;
    }

    /**
     * @param float $tmp_price
     * @return AdTradeResult
     */
    public function setTmpPrice($tmp_price)
    {
        $this->tmp_price = $tmp_price;
        return $this;
    }

    /**
     * @return float
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * @param float $change
     * @return AdTradeResult
     */
    public function setChange($change)
    {
        $this->change = $change;
        return $this;
    }

    /**
     * @param string $equation
     * @return bool|float
     */
    public function parseEquation(string $equation)
    {
        if (preg_match('/^btc_in_usd\*USD_in_UAH\*(\d+\.\d+)$/i', $equation, $parts)) {

            $this->setKoef($parts[1]);

            return (float)$parts[1];
        }

        return false;
    }
}