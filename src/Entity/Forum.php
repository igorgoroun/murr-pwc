<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumRepository")
 */
class Forum
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserGroup", inversedBy="forums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $access;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumDirectory", mappedBy="forum", orphanRemoval=true)
     */
    private $directories;

    /**
     * @var array $visibleDirs
     */
    private $visibleDirs = [];

    public function __construct()
    {
        $this->directories = new ArrayCollection();
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

    public function getAccess(): ?UserGroup
    {
        return $this->access;
    }

    public function setAccess(?UserGroup $access): self
    {
        $this->access = $access;

        return $this;
    }

    /**
     * @return Collection|ForumDirectory[]
     */
    public function getDirectories(): Collection
    {
        return $this->directories;
    }

    public function addDirectory(ForumDirectory $directory): self
    {
        if (!$this->directories->contains($directory)) {
            $this->directories[] = $directory;
            $directory->setForum($this);
        }

        return $this;
    }

    public function removeDirectory(ForumDirectory $directory): self
    {
        if ($this->directories->contains($directory)) {
            $this->directories->removeElement($directory);
            // set the owning side to null (unless already changed)
            if ($directory->getForum() === $this) {
                $directory->setForum(null);
            }
        }

        return $this;
    }

    public function getVisibleDirs(): array
    {
        return $this->visibleDirs;
    }

    public function addVisibleDir(ForumDirectory $directory): self
    {
        if (!in_array($directory, $this->visibleDirs, true)) {
            $this->visibleDirs []= $directory;
            $directory->setForum($this);
        }
        return $this;
    }

    public function removeVisibleDir(ForumDirectory $directory): self
    {
        if (in_array($directory, $this->visibleDirs, true)) {
            $key = array_search($directory, $this->visibleDirs, true);

            if (!$key === false) {
                unset($this->visibleDirs[$key]);

            }
            // set the owning side to null (unless already changed)
            if ($directory->getForum() === $this) {
                $directory->setForum(null);
            }
        }

        return $this;
    }

}
