<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="username_idx", columns={"username"})})
 */
class User
{
     /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
    */
    private $username;
    
    /**
     * @ORM\Column(type="string")
    */
    private $password;
    
    /**
     * @ORM\Column(type="string")
    */
    private $roles;

    /**
     * @ORM\Column(type="string", nullable=true)
    */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $items;
 
    public function __construct(string $username, string $password, string $roles)
    {
        if (empty($username))
        {
            throw new \InvalidArgumentException('No username provided.');
        }
 
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        $this->items = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }
 
    public function getUsername()
    {
        return $this->username;
    }
 
    public function getPassword()
    {
        return $this->password;
    }
 
    public function getRoles()
    {
        return explode(",", $this->roles);
    }
 
    public function getSalt()
    {
        return '';
    }
 
    public function eraseCredentials() {}

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function addItem()
    {
        return $this->items;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function hasItem(Item $item)
    {
        return $this->items->contains($item);
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function removeItem(Item $item)
    {
        $this->items->remove($item);
        return $this;
    }
}
