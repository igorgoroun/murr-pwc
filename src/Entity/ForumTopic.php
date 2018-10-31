<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumTopicRepository")
 */
class ForumTopic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="forumTopics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $heading;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     */
    private $postBody;

    /**
     * @var bool
     */
    private $sign = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ForumDirectory", inversedBy="topics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $directory;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pickedTop = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumPost", mappedBy="topic", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserGroup", inversedBy="forumTopics")
     */
    private $access;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var \App\Entity\ForumPost|null
     */
    private $latestPost = null;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

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

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function setHeading(string $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPostBody(): ?string
    {
        return $this->postBody;
    }

    public function setPostBody(?string $postBody): self
    {
        $this->postBody = $postBody;

        return $this;
    }

    public function getSign(): ?bool
    {
        return $this->sign;
    }

    public function setSign(bool $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    public function getDirectory(): ?ForumDirectory
    {
        return $this->directory;
    }

    public function setDirectory(?ForumDirectory $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    public function getPickedTop(): ?bool
    {
        return $this->pickedTop;
    }

    public function setPickedTop(bool $pickedTop): self
    {
        $this->pickedTop = $pickedTop;

        return $this;
    }

    /**
     * @return Collection|ForumPost[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(ForumPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setTopic($this);
        }

        return $this;
    }

    public function removePost(ForumPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getTopic() === $this) {
                $post->setTopic(null);
            }
        }

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(?\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return ForumPost|null
     */
    public function getLatestPost(): ?ForumPost
    {
        return $this->latestPost;
    }

    /**
     * @param ForumPost|null $latestPost
     * @return ForumTopic
     */
    public function setLatestPost(?ForumPost $latestPost): self
    {
        $this->latestPost = $latestPost;
        return $this;
    }
}
