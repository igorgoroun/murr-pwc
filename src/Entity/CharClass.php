<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharClassRepository")
 */
class CharClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="charClass", orphanRemoval=true)
     */
    private $chars;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PartyRole", inversedBy="classes")
     */
    private $partyRole;

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

    public function setName(string $name): self
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
            $char->setCharClass($this);
        }

        return $this;
    }

    public function removeChar(User $char): self
    {
        if ($this->chars->contains($char)) {
            $this->chars->removeElement($char);
            // set the owning side to null (unless already changed)
            if ($char->getCharClass() === $this) {
                $char->setCharClass(null);
            }
        }

        return $this;
    }

    public function getPartyRole(): ?PartyRole
    {
        return $this->partyRole;
    }

    public function setPartyRole(?PartyRole $partyRole): self
    {
        $this->partyRole = $partyRole;

        return $this;
    }
}
