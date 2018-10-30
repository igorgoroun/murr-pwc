<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 */
class UserGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="userRole", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Forum", mappedBy="access", orphanRemoval=true)
     */
    private $forums;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumDirectory", mappedBy="access", orphanRemoval=true)
     */
    private $forumDirectories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumTopic", mappedBy="access")
     */
    private $forumTopics;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->forums = new ArrayCollection();
        $this->forumDirectories = new ArrayCollection();
        $this->forumTopics = new ArrayCollection();
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
            $user->setUserRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserRole() === $this) {
                $user->setUserRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Forum[]
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->setAccess($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->contains($forum)) {
            $this->forums->removeElement($forum);
            // set the owning side to null (unless already changed)
            if ($forum->getAccess() === $this) {
                $forum->setAccess(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ForumDirectory[]
     */
    public function getForumDirectories(): Collection
    {
        return $this->forumDirectories;
    }

    public function addForumDirectory(ForumDirectory $forumDirectory): self
    {
        if (!$this->forumDirectories->contains($forumDirectory)) {
            $this->forumDirectories[] = $forumDirectory;
            $forumDirectory->setAccess($this);
        }

        return $this;
    }

    public function removeForumDirectory(ForumDirectory $forumDirectory): self
    {
        if ($this->forumDirectories->contains($forumDirectory)) {
            $this->forumDirectories->removeElement($forumDirectory);
            // set the owning side to null (unless already changed)
            if ($forumDirectory->getAccess() === $this) {
                $forumDirectory->setAccess(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ForumTopic[]
     */
    public function getForumTopics(): Collection
    {
        return $this->forumTopics;
    }

    public function addForumTopic(ForumTopic $forumTopic): self
    {
        if (!$this->forumTopics->contains($forumTopic)) {
            $this->forumTopics[] = $forumTopic;
            $forumTopic->setAccess($this);
        }

        return $this;
    }

    public function removeForumTopic(ForumTopic $forumTopic): self
    {
        if ($this->forumTopics->contains($forumTopic)) {
            $this->forumTopics->removeElement($forumTopic);
            // set the owning side to null (unless already changed)
            if ($forumTopic->getAccess() === $this) {
                $forumTopic->setAccess(null);
            }
        }

        return $this;
    }
}
