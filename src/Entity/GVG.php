<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GVGRepository")
 */
class GVG
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $enemy;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $territory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GVGPresence", mappedBy="gvg", orphanRemoval=true)
     */
    private $presences;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $hint;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getEnemy(): ?string
    {
        return $this->enemy;
    }

    public function setEnemy(?string $enemy): self
    {
        $this->enemy = $enemy;

        return $this;
    }

    public function getTerritory(): ?string
    {
        return $this->territory;
    }

    public function setTerritory(?string $territory): self
    {
        $this->territory = $territory;

        return $this;
    }

    /**
     * @return Collection|GVGPresence[]
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(GVGPresence $presence): self
    {
        if (!$this->presences->contains($presence)) {
            $this->presences[] = $presence;
            $presence->setGvg($this);
        }

        return $this;
    }

    public function removePresence(GVGPresence $presence): self
    {
        if ($this->presences->contains($presence)) {
            $this->presences->removeElement($presence);
            // set the owning side to null (unless already changed)
            if ($presence->getGvg() === $this) {
                $presence->setGvg(null);
            }
        }

        return $this;
    }


    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function setHint(?string $hint): self
    {
        $this->hint = $hint;

        return $this;
    }
}
