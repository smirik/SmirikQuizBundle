<?php

namespace Smirik\QuizBundle\Model;

class UserQuestion
{

  public function addAnswer($answer, $em)
  {
    /**
     * Check is this answer for question we need
     */
    if ($this->getQuestion()->getId() != $answer->getQuestionId())
    {
      throw new \Exception ('Question and Answer does not respond');
    }
    
    $this->setIsRight($answer->getIsRight());
    $this->setAnswer($answer);
    
    $em->persist($this);
    $em->flush();
  }

}