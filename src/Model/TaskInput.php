<?php
/**
 * Created by PhpStorm.
 * User: Himius
 * Date: 11.06.2018
 * Time: 14:49
 */

namespace App\Model;

use App\Document\Task;
use App\Document\UserAd;
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
     * @var UserAd
     */
    private $ad;
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
        if (!$this->algorithm && $this->command) {
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

    public function setCommand($command)
    {
        if ($command instanceof Algorithm) {
            $this->algorithm = $command;
            $command = $command->getName();
        }

        if (!$this->command
            || $this->command != $command
            || !$this->algorithm
        ) {
            $this->algorithm = $this->tm->getAlgorithm($command);
        }

        return parent::setCommand($command);
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
     * @return UserAd
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param UserAd|int
     * @return TaskInput
     */
    public function setAd($ad)
    {
        if (!$ad instanceof UserAd) {
            $ads = $this->tm->getUserAds($this->getProfile(), [
                'ad_id' => $ad
            ]);
            $ad = $ads[0]??null;
        };

        $this->ad = $ad;
        return $this;
    }
    
    public function setParams($params)
    {
        if (is_array($params) && $alg = $this->getAlgorithm()) {
            $class = $alg->getInputClass();
            $this->params = new $class;
            $this->params->setAttrs($params);
        } else {
            $this->params = $params;
        }
        
        return $this;
    }

}