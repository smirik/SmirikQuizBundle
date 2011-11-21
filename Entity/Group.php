<?php

namespace Smirik\QuizBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Smirik\QuizBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;

     /**
      * @ORM\ManyToMany(targetEntity="Smirik\QuizBundle\Entity\User")
      *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
      *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
      * )
      */
     public $users;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
      return $this->getName();
    }
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add users
     *
     * @param Smirik\QuizBundle\Entity\User $users
     */
    public function addUser(\Smirik\QuizBundle\Entity\User $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}