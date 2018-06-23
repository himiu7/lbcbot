<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use App\Entity\AttrsInterface;
use App\Entity\AttrsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Task
 * @package App\Document
 * @MongoDB\Document(collection="tasks")
 */
class Task
{
    use AttrsTrait;

    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_WAIT = 'wait';
    const STATUS_PAUSE = 'pause';
    const STATUS_ERROR = 'error';
    /**
     * @MongoDB\Id()
     */
    protected $id;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $title;
    /**
     * @MongoDB\Field(type="int")
     */
    protected $profile_id;
    /**
     * @MongoDB\Field(type="string")
     */
    protected $command;
    /**
     * @MongoDB\EmbedOne(
     *     discriminatorField="command",
     *     discriminatorMap={
     *         "lbc:sell-ad"="AdSellInput",
     *         "lbc:buy-ad"="AdBuyInput"
     *     }
     * )
     */
    protected $params;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @MongoDB\Index()
     */
    protected $list_id;
    /**
     * @var \MongoTimestamp
     * @MongoDB\Field(type="timestamp")
     */
    protected $last_start;
    /**
     * @var \MongoTimestamp
     * @MongoDB\Field(type="timestamp")
     */
    protected $next_start;
    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    protected $interval = 15;
    /**
     * @var AdTradeResult
     * @MongoDB\ReferenceOne(targetDocument="AdTradeResult", cascade={"persist","remove"})
     */
    protected $curr_result;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $status;
    /**
     * @var AdTradeResult[]
     * @MongoDB\ReferenceMany(targetDocument="AdTradeResult", cascade={"persist","remove"})
     */
    protected $results;
    /**
     * @var ApiProfile
     * @MongoDB\EmbedOne(targetDocument="ApiProfile")
     */
    private $api;
    /**
     * @var Market
     * @MongoDB\ReferenceOne(targetDocument="Market", cascade={"persist","remove"})
     */
    private $market;
    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->results = new ArrayCollection();
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
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return AttrsInterface
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param AttrsInterface $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param string $list_id
     * @return Task
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
        return $this;
    }

    /**
     * @return AdTradeResult
     */
    public function getCurrResult()
    {
        return $this->curr_result;
    }

    /**
     * @param AdTradeResult $curr_result
     * @return Task
     */
    public function setCurrResult($curr_result)
    {
        $this->curr_result = $curr_result;
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
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return Task
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
        return $this;
    }


    /**
     * @param string $status
     * @return array
     * @throws \Exception
     */
    public function getStatusTxt($status = null)
    {
        $statuses = [
            self::STATUS_NEW => 'New',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PAUSE => 'Pause',
            self::STATUS_ERROR => 'Error'
        ];

        if (!$status) {
            return $statuses;
        } elseif (!isset($statuses[$status])) {
            throw new \Exception('Invalid status');
        }
        return $statuses[$status];
    }

    /**
     * @return AdTradeResult[]|ArrayCollection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param AdTradeResult[] $results
     * @return Task
     */
    public function setResults($results)
    {
        $this->results = $results;
        return $this;
    }

    /**
     * @param AdTradeResult $result
     * @return Task
     */
    public function addResult(AdTradeResult $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setTask($this);
        }

        return $this;
    }

    /**
     * @param AdTradeResult $result
     * @return Task
     */
    public function removeResult(AdTradeResult $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getTask() === $this) {
                $result->setTask(null);
            }
        }

        return $this;
    }

    /**
     * @return \MongoTimestamp
     */
    public function getLastStart()
    {
        return $this->last_start;
    }

    /**
     * @param \MongoTimestamp $last_start
     * @return Task
     */
    public function setLastStart($last_start)
    {
        $this->last_start = $last_start;
        return $this;
    }

    /**
     * @return \MongoTimestamp
     */
    public function getNextStart()
    {
        return $this->next_start;
    }

    /**
     * @param \MongoTimestamp $next_start
     * @return Task
     */
    public function setNextStart($next_start)
    {
        $this->next_start = $next_start;
        return $this;
    }

    /**
     * @return ApiProfile
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param ApiProfile $api
     * @return Task
     */
    public function setApi($api)
    {
        $this->api = $api;
        return $this;
    }

    /**
     * @return Market
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * @param Market $market
     * @return Task
     */
    public function setMarket($market)
    {
        $this->market = $market;
        return $this;
    }

}