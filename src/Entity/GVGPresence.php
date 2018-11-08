<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GVGPresenceRepository")
 */
class GVGPresence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="gVGPresences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promise = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GVG", inversedBy="presences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gvg;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPromise(): ?bool
    {
        return $this->promise;
    }

    public function setPromise(bool $promise): self
    {
        $this->promise = $promise;

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
