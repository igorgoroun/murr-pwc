<?php

namespace App\Entity;

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


}
