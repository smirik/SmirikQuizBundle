<?php

namespace Smirik\QuizBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Smirik\QuizBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
  
  public function load($manager)
  {
    $question = new Question();
    $question->addQuiz($this->getReference('test_quiz'));
    $question->setText('Test question №1');
    $question->setType('text');
    $question->setNumAnswers(1);
    
    $manager->persist($question);
    $manager->flush();
    
    $this->addReference('question1', $question);
    
    for ($i=2; $i<6; $i++)
    {
      $question = new Question();
      $question->addQuiz($this->getReference('test_quiz'));
      $question->setText('Test question №'.$i);
      $question->setType('text');
      $question->setNumAnswers(4);
      
      $manager->persist($question);
      $manager->flush();
      
      $this->addReference('question'.$i, $question);
    }

    for ($i=1; $i<6; $i++)
    {
      $question = new Question();
      $question->addQuiz($this->getReference('test_quiz_without_time'));
      $question->setText('Test no time question №'.$i);
      $question->setType('text');
      $question->setNumAnswers(4);
      
      $manager->persist($question);
      $manager->flush();
      
      $this->addReference('t_question'.$i, $question);
    }    
  }
  
  public function getOrder()
  {
    return 4;
  }
  
}