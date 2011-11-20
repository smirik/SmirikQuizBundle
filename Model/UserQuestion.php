<?php

namespace Smirik\QuizBundle\Model;

class UserQuestion
{

  /**
   * Add user answer (with saving). With $answer_text — for questions with text answers
   * @param Smirik\QuizBundle\Entity\Answer $answer
   * @param $em
   * @param string $answer_text
   * @return void
   */
  public function addAnswer($answer, $em, $answer_text = false)
  {
    /**
     * Check is this answer for question we need
     */
    if ($this->getQuestion()->getId() != $answer->getQuestionId())
    {
      throw new \Exception ('Question and Answer does not respond');
    }
    
    if ($answer_text !== false)
    {
      if ($answer->getIsRight() == $answer_text)
      {
        $this->setIsRight(true);
      } else
      {
        $this->setIsRight(false);
      }
    } else
    {
      $this->setIsRight($answer->getIsRight());
    }
    
    $this->setAnswer($answer);
    
    $em->persist($this);
    $em->flush();
  }

}