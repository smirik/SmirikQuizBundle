<?php

namespace Smirik\QuizBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Smirik\QuizBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
  
  public function load($manager)
  {

    $user = new User();
    $user->setUsername('test');
    $user->setName('test');
    $user->addRole('ROLE_ADMIN');
    $user->setEmail('smirik@gmail.com');
    $user->setPlainPassword('test');
    $user->setEnabled(1);
    
    $manager->persist($user);
    $manager->flush();
    
    $this->addReference('test_user', $user);
    
    for ($i=1; $i<10; $i++)
    {
      $user = new User();
      $user->setUsername('test'.$i);
      $user->setName('test'.$i);
      $user->setEmail('smirik+'.$i.'@gmail.com');
      $user->setPlainPassword('test'.$i);
      $user->setEnabled(1);

      $manager->persist($user);
      $manager->flush();

      $this->addReference('test_user'.$i, $user);
    }
    
  }
  
  public function getOrder()
  {
    return 6;
  }
  
}
