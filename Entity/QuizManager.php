<?php
namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityManager;
use Smirik\QuizBundle\Entity\Quiz;

class QuizManager
{
  
  protected $em;
  protected $class;
  protected $repository;

  public function __construct(EntityManager $em, $class)
  {
    $this->em         = $em;
    $this->class      = $em->getClassMetadata($class)->name;
    $this->repository = $em->getRepository($class);
  }

  /**
   * Get all quizes
   * @param User $user
   * @return DoctrineCollection
   */
  public function getAvaliableQuizes($user)
  {
    return $this->repository->findBy(array(
      'is_opened' => true,
    ));
  }
  
  /**
   * Find all quizes
   * @param none
   * @return array
   */
  public function findAll()
  {
    return $this->repository->findAll();
  }
  
  /**
   * Get quiz by id
   * @param integer $id
   * @return Smirik\QuizBundle\Entity\Quiz
   */
  public function find($id)
  {
    return $this->repository->find($id);
  }
  
}
