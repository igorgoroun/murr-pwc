<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumDirectoryRepository")
 */
class ForumDirectory
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum", inversedBy="directories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $forum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserGroup", inversedBy="forumDirectories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $access;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumTopic", mappedBy="directory", orphanRemoval=true)
     */
    private $topics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumPost", mappedBy="directory", orphanRemoval=true)
     */
    private $posts;

    /**
     * @var \App\Entity\ForumPost|null
     */
    private $latestPost = null;

    /**
     * @return ForumPost|null
     */
    public function getLatestPost(): ?ForumPost
    {
        return $this->latestPost;
    }

    /**
     * @param ForumPost|null $latestPost
     * @return ForumDirectory
     */
    public function setLatestPost(?ForumPost $latestPost): self
    {
        $this->latestPost = $latestPost;
        return $this;
    }


    public function __construct()
    {
        $this->topics = new ArrayCollection();
        $this->posts = new ArrayCollection();
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

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

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
     * @return Collection|ForumTopic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(ForumTopic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setDirectory($this);
        }

        return $this;
    }

    public function removeTopic(ForumTopic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getDirectory() === $this) {
                $topic->setDirectory(null);
            }
        }

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
            $post->setDirectory($this);
        }

        return $this;
    }

    public function removePost(ForumPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getDirectory() === $this) {
                $post->setDirectory(null);
            }
        }

        return $this;
    }
}
