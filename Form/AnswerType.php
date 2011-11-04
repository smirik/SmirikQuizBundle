<?php

namespace Smirik\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AnswerType extends AbstractType
{
  
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
      ->add('title')
      ->add('file')
      ->add('is_right')
    ;
  }

  public function getDefaultOptions(array $options)
  {
    return array('data_class' => 'Smirik\QuizBundle\Entity\Answer');
  }
      
  public function getName()
  {
    return 'smirik_quizbundle_answertype';
  }
}
