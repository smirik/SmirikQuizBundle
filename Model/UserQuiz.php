<?php

namespace Smirik\QuizBundle\Model;

class UserQuiz
{
                   
  /**
   * Check quiz activity for given user
   * @param $user
   * @return boolean OR throw Exception
   */
  public function isActiveForUser($user)
  {
    if ($this->getUserId() != $user->getId())
    {
      throw new \Exception('This quiz is not active for current user');
    }
    
    if (($this->getIsClosed()) || (!is_null($this->getStoppedAt())))
    {
      throw new \Exception('This quiz is closed');
    }
    
    if (!$this->getIsActive())
    {
      throw new \Exception('This quiz was not started');
    }                                                   
    
    /**                
     * Check time of quiz
     * @todo use Server value
     */
    $now = time();
    $quiz_time = $this->getQuiz()->getTime();
    
    if ($quiz_time > 0)
    {
      $diff = strtotime($now - strtotime($this->getStartedAt()->format('Y-m-d H:i:s')));
      if ($diff > $quiz_time)
      {
        return false;
      }              
    }
    
    return true;
    
  }
  
  /**
   * Increment current question position
   * @param none
   * @return void
   */
  public function goNextQuestion()
  {
    $this->setCurrent($this->getCurrent() + 1);
  }
  
  /**
   * Decrement current question position
   * @param none
   * @return void
   */
  public function goPreviousQuestion()
  {
    if ($this->getCurrent() != 0)
    {
      $this->setCurrent($this->getCurrent() - 1);
    }
  }
  
  /**
   * Close UserQuiz, setup stop time, is_closed, number of right answers
   */
  public function close()
  {
    /**
     * Setup stop time and is_close
     */
    $this->setStoppedAt(new \DateTime('now'));
    $this->setIsClosed(true);
    
    /**
     * Calculating the number of right answers
     * Also close users_questions
     */
    $users_questions   = $this->getUsersQuestions();
    $num_right_answers = 0;
    foreach ($users_questions as $question)
    {
      $question->setIsClosed(true);
      if ($question->getIsRight())
      {
        $num_right_answers++;
      }
    }
    $this->setNumRightAnswers($num_right_answers);
    
  }
  
  /**
   * Return number of second left to the quiz
   * @param none
   * @return integer|false
   */
  public function countTimeLeft()
  {
    if ($this->getQuiz()->getTime() == 0)
    {
      return false;
    }
    
    $now = new \DateTime('now');
    $now = $now->getTimeStamp();
    $started_at = $this->getStartedAt()->getTimeStamp();
    
    $diff = $now - $started_at;
    $left_sec = $this->getQuiz()->getTime() - $diff;
    
    if ($left_sec <= 0)
    {
      return array(0, 0);
    } 
    
    $min = (int)($left_sec/60);
    $sec = $left_sec%60;
    
    return array('min' => $min, 'sec' => $sec);
  }
    
}