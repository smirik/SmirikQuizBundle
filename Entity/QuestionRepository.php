<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Smirik\QuizBundle\Entity\Question;
use Smirik\QuizBundle\Entity\Quiz;

/**
 * QuestionRepository
 */
class QuestionRepository extends EntityRepository
{
  
  /**
   * Get total number of questions for quiz
   * @param Smirik\QuizBundle\Entity\Quiz $quiz
   * @return integer
   */
  public function getNumberOfQuestionsForQuiz($quiz)
  {
    $count = $this->getEntityManager()->createQuery(
                    'SELECT COUNT(question.id) FROM SmirikQuizBundle:Question question
                     LEFT JOIN question.quizes a
                     WHERE (a.id = :quiz_id)')
                  ->setParameter('quiz_id', $quiz->getId())
                  ->getSingleScalarResult();
    return $count;
  }
  
}