<?php
namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityManager;
use Smirik\QuizBundle\Entity\UserQuiz;

class UserQuizManager
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
   * Get UserQuiz by id
   * @param integer $id
   * @return Smirik\QuizBundle\Entity\UserQuiz
   */
  public function find($id)
  {
    return $this->repository->find($id);
  }

  /**
   * Get UserQuiz by $user
   * @param $user
   * @param Smirik\QuizBundle\Entity\Quiz $quiz
   * @return Smirik\QuizBundle\Entity\UserQuiz|false
   */
  public function getActiveQuizForUser($user, $quiz)
  {
    $uq = $this->repository->createQueryBuilder('uq');
    
    if ($quiz->getTime() != 0)
    {
      /**
       * @todo hook. Doctrine developers didn't implement TIMEDIFF support. So we need in a ... hook!
       * Let's calculated possible started_at range from current time ($diff)
       */
      $now = time();
      $diff = date('Y-m-d H:i:s', $now-$quiz->getTime());
      $uq->where('(uq.user_id = :user_id) AND (uq.quiz_id = :quiz_id) AND (uq.started_at > :time) AND (uq.is_active = 1) AND (uq.is_closed = 0)')
         ->setParameter('time', $diff);
    } else
    {
      $uq->where('(uq.user_id = :user_id) AND (uq.quiz_id = :quiz_id) AND (uq.is_active = 1) AND (uq.is_closed = 0)');
    }
      
    $uq = $uq->setParameter('user_id', $user->getId())
             ->setParameter('quiz_id', $quiz->getId())
             ->setMaxResults(1)
             ->getQuery()
             ->getResult();
    if (isset($uq[0]) && $uq[0])
    {
      return $uq[0];
    }
    return false;
  }
  
  /**
   * Get array of UserQuiz by $user. With enabled $close close all old quizes.
   * @param $user
   * @param boolean $close
   * @param EntityManager $em
   * @return array|false
   */
  public function getAllActiveQuizForUser($user, $close = false, $em = false)
  {
    /**
     * @todo create repository method
     * @todo add time diff to DB query
     * @todo get objects with joined quiz
     */
    //$active_quiz = $this->repository->getActiveQuizForUser($user);
    $active_quiz = $this->repository->findBy(array(
      'user_id' => $user->getId(),
      'is_active' => true,
      'is_closed' => false,
    ));
    $now = new \DateTime('now');
    foreach ($active_quiz as $key => $u_quiz)
    {
      $diff = $now->getTimeStamp() - $u_quiz->getStartedAt()->getTimeStamp();
      if ($diff > $u_quiz->getQuiz()->getTime())
      {
        /**
         * If there is an option "close old quiz"
         */
        if ($close)
        {
          $u_quiz->setIsClosed(true);
          $em->persist($u_quiz);
          $em->flush();
        }
        unset($active_quiz[$key]);
      }
    }
    
    if (count($active_quiz) > 0)
    {
      return $active_quiz;
    }
    return false;
  }
  
  /**
   * Get all completed quizes 
   * @param $user
   * @return array
   */
  public function getAllCompletedQuizForUser($user)
  {
    $closed_quiz = $this->repository->findBy(array(
      'user_id' => $user->getId(),
      'is_active' => true,
      'is_closed' => true,
    ), array(
      'started_at' => 'DESC',
    ));
    return $closed_quiz;
  }

  /**
   * Create UserQuiz object
   * @param Smirik\QuizBundle\Entity\User $user
   * @param Smirik\QuizBundle\Entity\Quiz $quiz
   * @param array $questions
   * @param $em
   * @return UserQuiz
   */
  public function create($user, $quiz, $questions, $em)
  {
    $user_quiz = new UserQuiz();
    $user_quiz->setUser($user);
    $user_quiz->setQuiz($quiz);
    $user_quiz->setQuizId($quiz->getId());
    
    $questions_array = array();
    foreach ($questions as $question)
    {
      $questions_array[] = $question->getId();
    }
    $user_quiz->setQuestions(json_encode($questions_array));

    $user_quiz->setCurrent(0);
    $user_quiz->setStartedAt(new \DateTime('now'));
    $user_quiz->setIsActive(true);
    $user_quiz->setIsClosed(false);
    
    $em->persist($user_quiz);
    $em->flush();
    
    return $user_quiz;
  }

}