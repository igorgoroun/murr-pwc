<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CVRepository")
 */
class CV
{

    static $ages = [
        0 => 'Less than 18',
        1 => 'From 18 to 29',
        2 => '30 and more'
    ];

    static $levels = [
        1 => '10+',
        2 => '20+',
        3 => '30+',
        4 => '40+',
        5 => '50+',
        6 => '60+',
        7 => '70+',
        8 => '80+',
        9 => '90+',
        10 => '100+'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CharSide")
     * @ORM\JoinColumn(nullable=false)
     */
    private $charSide;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $closed = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CVvote", mappedBy="cv", orphanRemoval=true)
     */
    private $votes;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getAgeText(): ?string {
        return self::$ages[$this->age];
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }
    public function isAccepted(): ?bool
    {
        return ($this->accepted && $this->closed);
    }
    public function isDeclined(): ?bool
    {
        return (!$this->accepted && $this->closed);
    }
    public function isProcessing(): ?bool
    {
        return !$this->closed;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }
    public function getLevelText(): ?string {
        return self::$levels[$this->level];
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|CVvote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(CVvote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setCv($this);
        }

        return $this;
    }

    public function removeVote(CVvote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getCv() === $this) {
                $vote->setCv(null);
            }
        }

        return $this;
    }
}
