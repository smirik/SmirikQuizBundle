<?php

namespace Smirik\QuizBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Smirik\QuizBundle\Entity\Answer;

class LoadAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
  
  public function load($manager)
  {
    
    for ($i=1; $i<6; $i++)
    {
      for ($j=1; $j<5; $j++)
      {
        $answer = new Answer();
        $answer->setQuestion($this->getReference('question'.$i));
        $answer->setTitle('Test answer '.$i.' №'.$j);
        if (($j%4) == ($i%4))
        {
          $answer->setIsRight(1);
        } else
        {
          $answer->setIsRight(0);
        }
        
        $manager->persist($answer);
        $manager->flush();
      }
    }
    
  }
  
  public function getOrder()
  {
    return 5;
  }
  
}