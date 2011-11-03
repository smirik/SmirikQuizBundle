<?php

namespace Smirik\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Smirik\QuizBundle\Entity\Question;

class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
  
  public function load($manager)
  {
    
    for ($i=1; $i<6; $i++)
    {
      $question = new Question();
      $question->setQuiz($this->getReference('test_quiz'));
      $question->setText('Test question №'.$i);
      $question->setType('text');
      $question->setNumAnswers(4);
      
      $manager->persist($question);
      $manager->flush();
      
      $this->addReference('question'.$i, $question);
    }
    
  }
  
  public function getOrder()
  {
    return 4;
  }
  
}