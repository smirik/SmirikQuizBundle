<?php
namespace Smirik\QuizBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use FOS\UserBundle\Entity\UserManager as BaseUserManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;

/**
 */
class UserManager
{

  protected $em;
  protected $class;
  protected $repository;

  public function __construct(EntityManager $em, $class)
  {
    $this->em         = $em;
    $this->class      = $em->getClassMetadata($class)->name;
    $this->repository = $em->getRepository($class);
    
    parent::__construct();
  }
  
  public function findUsersByGroup($group)
  {
    var_dump($group->getName());
    exit();
  }
  
}