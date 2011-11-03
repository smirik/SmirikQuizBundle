<?php

namespace Smirik\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('time')
            ->add('num_questions')
            ->add('is_active')
        ;
    }

    public function getName()
    {
        return 'smirik_quizbundle_quiztype';
    }
}
