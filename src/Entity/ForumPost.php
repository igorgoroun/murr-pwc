<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumPostRepository")
 */
class ForumPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="forumPosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sign = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ForumTopic", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $topic;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pickTop = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ForumDirectory", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $directory;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

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

    public function getTopic(): ?ForumTopic
    {
        return $this->topic;
    }

    public function setTopic(?ForumTopic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getPickTop(): ?bool
    {
        return $this->pickTop;
    }

    public function setPickTop(bool $pickTop): self
    {
        $this->pickTop = $pickTop;

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
}
