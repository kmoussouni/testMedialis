<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\ItemRepository::class)
 * @ORM\Table
 */
class Item
{
     /**
      * @ORM\Id
      * @ORM\Column(type="integer")
      * @ORM\GeneratedValue
      */
    protected $id;

     /**
      * @ORM\Column(type="string")
      * @var                       string
      */
    protected $message;

     /**
      * @ORM\Column(type="boolean")
      * @var                        bool
      */
    protected $checked;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="items")
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Item")
     */
    protected $item;

    public function getId()
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;

    }

    public function setMessage($message): Item
    {
        $this->message = $message;
        return $this;

    }

    /**
     * Get the value of item
     */ 
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set the value of item
     *
     * @return  self
     */ 
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get the value of checked
     *
     * @return  boolean
     */ 
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set the value of checked
     *
     * @param  bool  $checked
     *
     * @return  self
     */ 
    public function setChecked(bool $checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
