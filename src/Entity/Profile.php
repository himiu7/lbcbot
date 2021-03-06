<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Api\LbcBundle\ApiProfileInterface;

/**
 * Profile
 *
 * @ORM\Table(name="`profile`", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Profile implements ApiProfileInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=80, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="`key`", type="string", length=32, nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="secret", type="string", length=64, nullable=false)
     */
    private $secret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_ads_update", type="datetime", nullable=true)
     */
    private $lastAdsUpdate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;

        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
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
     * @return Profile
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastAdsUpdate()
    {
        return $this->lastAdsUpdate;
    }

    /**
     * @param \DateTime $lastAdsUpdate
     * @return $this
     */
    public function setLastAdsUpdate(\DateTime $lastAdsUpdate)
    {
        $this->lastAdsUpdate = $lastAdsUpdate;

        return $this;
    }
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime());
        }
    }
}
