<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 10.06.2018
 * Time: 19:13
 */

namespace App\Document;

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
}