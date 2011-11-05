<?php

namespace Smirik\QuizBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Smirik\QuizBundle\Entity\Quiz;

class LoadQuizData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load($manager)
  {
    
    $quiz = new Quiz();
    $quiz->setTitle('Test Quiz');
    $quiz->setDescription('This quiz was created just for ... tests');
    $quiz->setTime(10*60);
    $quiz->setIsActive(true);
    $quiz->setNumQuestions(3);
    
    $manager->persist($quiz);
    $manager->flush();
    
    $this->addReference('test_quiz', $quiz);
    
  }

  public function getOrder()
  {
    return 3;
  }
  
}
