<?php

namespace Smirik\QuizBundle\Model;
use Symfony\Component\Validator\Constraints as Assert;

class Question
{
  
  /**
   * @Assert\File(maxSize="6000000")
   */
  public $v_file;
  
  public function upload()
  {
    if (null !== $this->v_file) {
      $this->v_file->move($this->getUploadRootDir(), $this->v_file->getClientOriginalName());
      $this->setFile($this->v_file->getClientOriginalName());
      $this->v_file = null;
    }
    /**
     * Add upload for subentites
     */
    foreach ($this->getAnswers() as $answer)
    {
      $answer->upload();
    }
      
  }
    
  public function getAbsolutePath()
  {
    return null === $this->getFile() ? null : $this->getUploadRootDir().'/'.$this->getFile();
  }

  public function getWebPath()
  {
    return null === $this->getFile() ? null : $this->getUploadDir().'/'.$this->getFile();
  }

  /**
   * the absolute directory path where uploaded documents should be saved
   */
  protected function getUploadRootDir()
  {
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

  protected function getUploadDir()
  {
    return 'uploads/quiz';
  }
  
  public function __toString()
  {
    return $this->getText();
  }
  
  public function getFirstQuiz()
  {
    return $this->getQuizes()->first();
  }
  
  
}