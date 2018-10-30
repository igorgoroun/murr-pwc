<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharSideRepository")
 */
class CharSide
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
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="charSide")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CV", mappedBy="charSide", orphanRemoval=true)
     */
    private $cVs;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cVs = new ArrayCollection();
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
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCharSide($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCharSide() === $this) {
                $user->setCharSide(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CV[]
     */
    public function getCVs(): Collection
    {
        return $this->cVs;
    }

    public function addCV(CV $cV): self
    {
        if (!$this->cVs->contains($cV)) {
            $this->cVs[] = $cV;
            $cV->setCharSide($this);
        }

        return $this;
    }

    public function removeCV(CV $cV): self
    {
        if ($this->cVs->contains($cV)) {
            $this->cVs->removeElement($cV);
            // set the owning side to null (unless already changed)
            if ($cV->getCharSide() === $this) {
                $cV->setCharSide(null);
            }
        }

        return $this;
    }
}
