<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GVGPartyRepository")
 */
class GVGParty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="gVGParties")
     */
    private $chars;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promise = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $was = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GVG", inversedBy="parties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gvg;

    public function __construct()
    {
        $this->chars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getChars(): Collection
    {
        return $this->chars;
    }

    public function addChar(User $char): self
    {
        if (!$this->chars->contains($char)) {
            $this->chars[] = $char;
        }

        return $this;
    }

    public function removeChar(User $char): self
    {
        if ($this->chars->contains($char)) {
            $this->chars->removeElement($char);
        }

        return $this;
    }

    public function getPromise(): ?bool
    {
        return $this->promise;
    }

    public function setPromise(bool $promise): self
    {
        $this->promise = $promise;

        return $this;
    }

    public function getWas(): ?bool
    {
        return $this->was;
    }

    public function setWas(?bool $was): self
    {
        $this->was = $was;

        return $this;
    }

    public function getGvg(): ?GVG
    {
        return $this->gvg;
    }

    public function setGvg(?GVG $gvg): self
    {
        $this->gvg = $gvg;

        return $this;
    }
}
