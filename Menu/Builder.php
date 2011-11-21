<?php
// src/Acme/DemoBundle/Menu/Builder.php
namespace Smirik\QuizBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('admin.quiz.navigation.quizes',     array('route' => 'smirik_quiz_admin_quiz'));
        $menu->addChild('admin.quiz.navigation.questions',  array('route' => 'smirik_quiz_admin_questions'));
        $menu->addChild('admin.quiz.navigation.users_quiz', array('route' => 'smirik_quiz_admin_users_index'));
        $menu->addChild('admin.quiz.navigation.groups',     array('route' => 'fos_user_group_list'));
        $menu->addChild('admin.quiz.navigation.content',    array('route' => 'sonata_admin_dashboard'));

        return $menu;
    }
}