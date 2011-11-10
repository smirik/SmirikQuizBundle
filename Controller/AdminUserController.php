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
  * @Route("/", name="smirik_quiz_admin_users_index")
  * @Template("SmirikQuizBundle:Admin\User:index.html.twig")
  */
  public function indexAction()
  {
    $um = $this->get('fos_user.user_manager');
    $gm = $this->get('fos_user.group_manager');
    $qm = $this->get('quiz.manager');
    
    $group_id = $this->getRequest()->query->get('group_id', false);
    $groups = $gm->findGroups();
    if ($group_id)
    {
      /**
       * Here we should show just users for current group
       * Unfortunately i don't know how to rewrite default user manager in FOSUserBundle
       * So let's take all users 
       * @todo Get users by group_id
       */
      $users = $um->findUsers();
    } else
    {
      $users = $um->findUsers();
    }
    
    $quizes = $qm->findAll();
    
    return array(
      'users'  => $users,
      'quizes' => $quizes,
      'groups' => $groups,
    );
  }
  
  /**
  * Connect users to quiz
  *
  * @Route("/connect", name="smirik_quiz_admin_users_connect")
  * @Method("post")
  */
  public function connectAction()
  {  
    $um  = $this->get('fos_user.user_manager');
    $qm  = $this->get('quiz.manager');
    $uqm = $this->get('user_quiz.manager');
    $qum = $this->get('question.manager');
    $em  = $this->getDoctrine()->getEntityManager();
    
    $users   = $this->getRequest()->request->get('users', false);
    $quiz_id = $this->getRequest()->request->get('quiz_id', false);
    
    if (!$users || !$quiz_id)
    {
      return $this->redirect($this->generateUrl('smirik_quiz_admin_users_index'));
    }
    
    $quiz = $qm->find($quiz_id);
    if (!$quiz)
    {
      return $this->redirect($this->generateUrl('smirik_quiz_admin_users_index'));
    }
    
    /**
     * @todo Get all users at one moment. Fix in UserManager
     * Opening quizes for all users
     */
    foreach ($users as $user_id)
    {
      $user = $um->findUserBy(array('id' => $user_id));
      $user_quiz = $uqm->getActiveQuizForUser($user, $quiz);
      /**
       * If user has active quiz there is no need to open one more.
       */
      if (!$user_quiz)
      {
        $questions = $qum->getRandomQuestionsForQuiz($quiz, $quiz->getNumQuestions());
        $user_quiz = $uqm->create($user, $quiz, $questions, $em);
      }
    }
    
    $this->get('session')->setFlash('message',"users.quiz.created");
    
    return $this->redirect($this->generateUrl('smirik_quiz_admin_users_index'));
  }
  
}