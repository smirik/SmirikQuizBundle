<?php
namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityManager;
use Smirik\QuizBundle\Entity\Answer;

class AnswerManager
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
   * Get answer by id
   * @param integer $id
   * @return Smirik\QuizBundle\Entity\Answer
   */
  public function find($id)
  {
    return $this->repository->find($id);
  }



}