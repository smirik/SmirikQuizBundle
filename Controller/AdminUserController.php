<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Smirik\QuizBundle\Entity\UserQuiz;

/**
 * User controller.
 *
 * @Route("/admin/users")
 */
class AdminUserController extends Controller
{
  
  /**
  * Finds and displays a users.
  *
  * @Route("/", name="admin_users_index")
  * @Template("SmirikQuizBundle:Admin\User:index.html.twig")
  */
  public function indexAction()
  {
    $um = $this->get('fos_user.user_manager');
    $gm = $this->get('fos_user.group_manager');
    $qm = $this->get('quiz.manager');
    
    $group_id = $this->getRequest()->query->get('group_id', false);
    if ($group_id)
    {
      
    } else
    {
      $groups = $gm->findGroups();
    }
    
    $users = $um->findUsers();
    $quizes = $qm->findAll();
    
    return array(
      'users'  => $users,
      'quizes' => $quizes,
      'groups' => $groups,
    );
  }
  
}