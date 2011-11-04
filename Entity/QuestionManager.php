<?php
namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityManager;
use Smirik\QuizBundle\Entity\Question;

class QuestionManager
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
   * Get question by id
   * @param integer $id
   * @return Smirik\QuizBundle\Entity\Question
   */
  public function find($id)
  {
    return $this->repository->find($id);
  }
  
  /**
   * Get $num random questions for given $quiz
   * @param Smirik\QuizBundle\Entity\Quiz $quiz
   * @param integer $num
   * @return array of Question|false
   */
  public function getRandomQuestionsForQuiz($quiz, $num = 3)
  {
    $total_num = $this->repository->getNumberOfQuestionsForQuiz($quiz);
    
    /**
     * If there is no enough questions
     */
    if ($total_num < $num)
    {
      return false;
    }
    
    /**
     * Get $num random numbers from 1 to $total_num
     */
    $rand_numbers = array();
    $counter = 0;
    while ($counter < $num)
    {
      $rand = rand(0, ($total_num-1));
      if (!in_array($rand, $rand_numbers))
      {
        array_push($rand_numbers, $rand);
        $counter++;
      }
    }
    
    /**
     * Get questions with given offset
     * @todo speed up
     */
    $questions = array();
    for ($i=0; $i<$num; $i++)
    {
      $question = $this->repository->createQueryBuilder('q')
        ->where('q.quiz_id = :quiz_id')
        ->setParameter('quiz_id', $quiz->getId())
        ->setFirstResult($rand_numbers[$i])
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
      array_push($questions, $question[0]);
    }
    
    return $questions;
  }
  
}
