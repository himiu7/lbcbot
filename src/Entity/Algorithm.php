<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="algorithm")
 * @ORM\Entity(repositoryClass="App\Repository\AlgorithmRepository")
 */
class Algorithm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $inputClass;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $resultClass;

    /**
     * @var AlgorithmParam[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\AlgorithmParam", mappedBy="algorithm",  cascade={"persist", "remove"})
     */
    private $params;

    public function __construct()
    {
        $this->params = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInputClass(): string
    {
        return $this->inputClass;
    }

    public function setInputClass(string $inputClass): self
    {
        $this->inputClass = $inputClass;

        return $this;
    }

    public function getResultClass(): string
    {
        return $this->resultClass;
    }

    public function setResultClass(string $resultClass): self
    {
        $this->resultClass = $resultClass;

        return $this;
    }

    /**
     * @return Collection|AlgorithmParam[]
     */
    public function getParams(): Collection
    {
        return $this->params;
    }

    public function addParam(AlgorithmParam $param): self
    {
        if (!$this->params->contains($param)) {
            $this->params[] = $param;
            $param->setAlgorithm($this);
        }

        return $this;
    }

    public function removeParam(AlgorithmParam $param): self
    {
        if ($this->params->contains($param)) {
            $this->params->removeElement($param);
            // set the owning side to null (unless already changed)
            if ($param->getAlgorithm() === $this) {
                $param->setAlgorithm(null);
            }
        }

        return $this;
    }
}
