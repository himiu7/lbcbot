<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 05.06.2018
 * Time: 22:45
 */

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Task
 * @package App\Document
 * @MongoDB\Document(collection="tasks")
 */
class Task
{
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
     */
    protected $list_id;
    /**
     * @var \DateTime
     * @MongoDB\Field(type="date")
     */
    protected $last_start;
    /**
     * @var int
     * @MongoDB\Field(type="int")
     */
    protected $interval = 15;
    /**
     * @var AdTradeResult
     * @MongoDB\ReferenceOne(targetDocument="AdTradeResult")
     */
    protected $curr_result;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $status;
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
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
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
     * @return \DateTime
     */
    public function getLastStart()
    {
        return $this->last_start;
    }

    /**
     * @param \DateTime $last_start
     * @return Task
     */
    public function setLastStart($last_start)
    {
        $this->last_start = $last_start;
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

}