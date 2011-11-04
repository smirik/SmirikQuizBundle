<?php

namespace Smirik\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuestionType extends AbstractType
{
  
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
      ->add('quiz')
      ->add('text')
      ->add('type')
      ->add('file')
      ->add('num_answers')
      ->add('answers', 'collection', array(
        'type'         => new AnswerType(),
        'allow_add'    => true,
        'allow_delete' => true,
        'prototype'    => true,
      ))
    ;
  }

  public function getName()
  {
    return 'smirik_quizbundle_questiontype';
  }
}
