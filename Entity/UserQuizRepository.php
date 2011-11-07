<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Smirik\QuizBundle\Entity\UserQuiz;

/**
 * UserQuizRepository
 */
class UserQuizRepository extends EntityRepository
{
  
  /**
   * Get total number of questions for quiz
   * @param $user
   * @return DoctrineCollection
   */
  public function getActiveQuizForUser($user)
  {
    $now = time();
    
    /**
     * @todo No support for TIME_DIFF
     * Let's do this by hands
     */
    $active_quiz = $this->getEntityManager()->createQuery('
        SELECT uq, q FROM SmirikQuizBundle:UserQuiz uq
        INNER JOIN uq.quiz q
        WHERE (uq.user_id = :user_id) AND 
              (uq.is_active = 1) AND (uq.is_closed = 0)
      ')
      ->setParameter('user_id', $user->getId())
      ->getResult();
    foreach ($active_quiz as $quiz)
    {
      var_dump($quiz->getId());
      exit();
    }
  }
  
}