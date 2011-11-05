<?php

namespace Smirik\QuizBundle\Model;

class Quiz
{

  public function generateNewQuizForUser($user)
  {
    /**
     * Get num_questions Question Collection
     */
    
  }
  
  public function __toString()
  {
    return $this->getTitle();
  }
    
}