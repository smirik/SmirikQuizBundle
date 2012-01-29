<?php

namespace Smirik\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuestionType extends AbstractType
{
  
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder
      ->add('quizes')
      ->add('text', 'textarea', array('attr' => array('class' => 'tinymce xxlarge ylarge', 'tinymce' => '{"theme":"simple"}')))
      ->add('type', 'choice', array(
        'choices' => array('text' => 'text', 'radio' => 'radio', 'checkbox' => 'checkbox')
      ))
      ->add('v_file')
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
