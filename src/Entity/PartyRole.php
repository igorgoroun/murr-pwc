<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartyRoleRepository")
 */
class PartyRole
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
     * @ORM\OneToMany(targetEntity="App\Entity\CharClass", mappedBy="partyRole")
     */
    private $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
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
     * @return Collection|CharClass[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(CharClass $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setPartyRole($this);
        }

        return $this;
    }

    public function removeClass(CharClass $class): self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getPartyRole() === $this) {
                $class->setPartyRole(null);
            }
        }

        return $this;
    }
}
