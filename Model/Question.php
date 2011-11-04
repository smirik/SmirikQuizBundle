<?php

namespace Smirik\QuizBundle\Model;

class Question
{
  
  public function __toString()
  {
    return $this->getText();
  }
  
}