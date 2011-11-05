<?php
namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityManager;
use Smirik\QuizBundle\Entity\UserQuestion;

class UserQuestionManager
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
   * Get UserQuestion by id
   * @param integer $id
   * @return Smirik\QuizBundle\Entity\UserQuestion
   */
  public function find($id)
  {
    return $this->repository->find($id);
  }

  /**
   * Find or create UserQuestion for given UserQuiz & Question
   */
  public function findOrCreate($user_quiz, $question, $em)
  {
    $user_question = $this->repository->findOneBy(array(
      'user_id'      => $user_quiz->getUserId(),
      'quiz_id'      => $user_quiz->getQuizId(),
      'question_id'  => $question->getId(),
      'user_quiz_id' => $user_quiz->getId(),
    ));
    if ($user_question)
    {
      return $user_question;
    }
    
    /**
     * If there is no record in DB then create new UserQuestion with given properties
     */
    $user_question = new UserQuestion();
    $user_question->setUser($user_quiz->getUser());
    $user_question->setQuiz($user_quiz->getQuiz());
    $user_question->setQuestion($question);
    $user_question->setUserQuiz($user_quiz);
    
    $em->persist($user_question);
    $em->flush();
    
    return $user_question;
  }
  
  /**
   * Find UserQuestion for given UserQuiz & Question
   */
  public function findByUserQuiz($user_quiz, $question)
  {
    $user_question = $this->repository->findOneBy(array(
      'user_id'      => $user_quiz->getUserId(),
      'quiz_id'      => $user_quiz->getQuizId(),
      'question_id'  => $question->getId(),
      'user_quiz_id' => $user_quiz->getId(),
    ));
    if ($user_question)
    {
      return $user_question;
    }
    return false;
  }

}