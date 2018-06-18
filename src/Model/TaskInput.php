<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 11.06.2018
 * Time: 14:49
 */

namespace App\Model;

use App\Document\Task;
use App\Entity\Algorithm;
use App\Entity\Profile;
use App\Service\TaskManager;
use Doctrine\ORM\EntityManagerInterface;

class TaskInput extends Task
{
    /**
     * @var TaskManager
     */
    private $tm;
    /**
     * @var Algorithm
     */
    private $algorithm;
    /**
     * @var Profile
     */
    private $profile;
    /**
     * @var integer
     */
    private $ad_id;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TaskManager $tm, EntityManagerInterface $em)
    {
        $this->tm = $tm;
        $this->em = $em;
    }
    /**
     * @return Algorithm
     */
    public function getAlgorithm()
    {
        if (!$this->algorithm) {
            $this->algorithm = $this->tm->getAlgorithm($this->command);
        }

        return $this->algorithm;
    }

    /**
     * @param Algorithm $algorithm
     * @return $this
     */
    public function setAlgorithm(Algorithm $algorithm)
    {
        $this->command = $algorithm->getName();
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        if ($this->profile_id
            && (
                !$this->profile
                || ($this->profile->getId() != $this->profile_id)
            )
        ) {
            $this->profile = $this->em->getRepository(Profile::class)
                ->find($this->profile_id);
        }

        return $this->profile;
    }

    /**
     * @return int
     */
    public function getAdId()
    {
        return $this->ad_id;
    }

    /**
     * @param int $ad_id
     * @return TaskInput
     */
    public function setAdId($ad_id)
    {
        $this->ad_id = $ad_id;
        return $this;
    }

}