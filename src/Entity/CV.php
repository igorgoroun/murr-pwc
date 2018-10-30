<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CVRepository")
 */
class CV
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CharClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $charClass;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $twins;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gvgExperience;

    /**
     * @ORM\Column(type="text")
     */
    private $previousExits;

    /**
     * @ORM\Column(type="text")
     */
    private $ourReasons;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $guarantors;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmStatement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="CVs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CharSide", inversedBy="cVs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $charSide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCharClass(): ?CharClass
    {
        return $this->charClass;
    }

    public function setCharClass(?CharClass $charClass): self
    {
        $this->charClass = $charClass;

        return $this;
    }


    public function getTwins(): ?string
    {
        return $this->twins;
    }

    public function setTwins(?string $twins): self
    {
        $this->twins = $twins;

        return $this;
    }

    public function getGvgExperience(): ?bool
    {
        return $this->gvgExperience;
    }

    public function setGvgExperience(bool $gvgExperience): self
    {
        $this->gvgExperience = $gvgExperience;

        return $this;
    }

    public function getPreviousExits(): ?string
    {
        return $this->previousExits;
    }

    public function setPreviousExits(string $previousExits): self
    {
        $this->previousExits = $previousExits;

        return $this;
    }

    public function getOurReasons(): ?string
    {
        return $this->ourReasons;
    }

    public function setOurReasons(string $ourReasons): self
    {
        $this->ourReasons = $ourReasons;

        return $this;
    }

    public function getGuarantors(): ?string
    {
        return $this->guarantors;
    }

    public function setGuarantors(?string $guarantors): self
    {
        $this->guarantors = $guarantors;

        return $this;
    }

    public function getConfirmStatement(): ?bool
    {
        return $this->confirmStatement;
    }

    public function setConfirmStatement(bool $confirmStatement): self
    {
        $this->confirmStatement = $confirmStatement;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCharSide(): ?CharSide
    {
        return $this->charSide;
    }

    public function setCharSide(?CharSide $charSide): self
    {
        $this->charSide = $charSide;

        return $this;
    }
}
