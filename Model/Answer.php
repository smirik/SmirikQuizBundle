<?php

namespace Smirik\QuizBundle\Model;
use Symfony\Component\Validator\Constraints as Assert;

class Answer
{
  
  /**
   * @Assert\File(maxSize="6000000")
   */
  public $v_file;
  
  public function upload()
  {
    if (null === $this->v_file) {
        return;
    }
    $this->v_file->move($this->getUploadRootDir(), $this->v_file->getClientOriginalName());
    $this->setFile($this->v_file->getClientOriginalName());
    $this->v_file = null;
  }
    
  public function getAbsolutePath()
  {
      return null === $this->getFile() ? null : $this->getUploadRootDir().'/'.$this->getFile();
  }

  public function getWebPath()
  {
      return null === $this->getFile() ? null : $this->getUploadDir().'/'.$this->getFile();
  }

  protected function getUploadRootDir()
  {
      // the absolute directory path where uploaded documents should be saved
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

  protected function getUploadDir()
  {
      // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
      return 'uploads/quiz/answers/';
  }
  
  public function __toString()
  {
    return $this->getTitle();
  }
  
}