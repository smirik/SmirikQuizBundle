<?php

namespace Smirik\QuizBundle\Model;

class Quiz
{
 
  public function __toString()
  {
    return $this->getTitle();
  }
  
}