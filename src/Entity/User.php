<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
    private $realName;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $nickName;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CharClass", inversedBy="chars")
     * @ORM\JoinColumn(nullable=true)
     */
    private $charClass;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserGroup", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userRole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CharSide", inversedBy="users")
     */
    private $charSide;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CV", mappedBy="user", orphanRemoval=true)
     */
    private $CVs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumTopic", mappedBy="user", orphanRemoval=true)
     */
    private $forumTopics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumPost", mappedBy="user", orphanRemoval=true)
     */
    private $forumPosts;

    public function __construct()
    {
        $this->CVs = new ArrayCollection();
        $this->forumTopics = new ArrayCollection();
        $this->forumPosts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealName(): ?string
    {
        return $this->realName;
    }

    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }



    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        //return array('ROLE_GUEST');
        return [$this->getUserRole()->getRole()];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->getRealName();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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

    public function getUserRole(): ?UserGroup
    {
        return $this->userRole;
    }

    public function setUserRole(?UserGroup $userRole): self
    {
        $this->userRole = $userRole;

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

    /**
     * @return Collection|CV[]
     */
    public function getCVs(): Collection
    {
        return $this->CVs;
    }

    public function addCV(CV $cV): self
    {
        if (!$this->CVs->contains($cV)) {
            $this->CVs[] = $cV;
            $cV->setUser($this);
        }

        return $this;
    }

    public function removeCV(CV $cV): self
    {
        if ($this->CVs->contains($cV)) {
            $this->CVs->removeElement($cV);
            // set the owning side to null (unless already changed)
            if ($cV->getUser() === $this) {
                $cV->setUser(null);
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
            $forumTopic->setUser($this);
        }

        return $this;
    }

    public function removeForumTopic(ForumTopic $forumTopic): self
    {
        if ($this->forumTopics->contains($forumTopic)) {
            $this->forumTopics->removeElement($forumTopic);
            // set the owning side to null (unless already changed)
            if ($forumTopic->getUser() === $this) {
                $forumTopic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ForumPost[]
     */
    public function getForumPosts(): Collection
    {
        return $this->forumPosts;
    }

    public function addForumPost(ForumPost $forumPost): self
    {
        if (!$this->forumPosts->contains($forumPost)) {
            $this->forumPosts[] = $forumPost;
            $forumPost->setUser($this);
        }

        return $this;
    }

    public function removeForumPost(ForumPost $forumPost): self
    {
        if ($this->forumPosts->contains($forumPost)) {
            $this->forumPosts->removeElement($forumPost);
            // set the owning side to null (unless already changed)
            if ($forumPost->getUser() === $this) {
                $forumPost->setUser(null);
            }
        }

        return $this;
    }


}
