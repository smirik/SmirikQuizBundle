<?php

namespace Smirik\QuizBundle\EventListener;

use Smirik\AdminBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param \Smirik\AdminBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('admin.quiz.menu', array('route' => 'smirik_quiz_admin_quiz'));
        $menu->addChild('admin.quiz.users.menu', array('route' => 'smirik_quiz_admin_users_index'));
    }
}