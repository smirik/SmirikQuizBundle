<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Smirik\QuizBundle\Entity\Quiz;
use Smirik\QuizBundle\Entity\Question;
use Smirik\QuizBundle\Form\QuizType;

/**
 * Quiz controller.
 *
 * @Route("/quiz")
 */
class QuizController extends Controller
{
  
  /**
  * Show user avaliable quizes.
  *
  * @Route("/", name="quiz_index")
  * @Template("SmirikQuizBundle:Quiz:index.html.twig")
  */
  public function indexAction()
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $qm   = $this->get('quiz.manager');
    
    $quizes = $qm->getAvaliableQuizes($user);
    return array(
      'quizes' => $quizes,
    );
  }
  
  /**
   * Start new quiz for current user
   * @Route("/start/{quiz_id}", name="quiz_start")
   * @Template("SmirikQuizBundle:Quiz:start.html.twig", vars={"get"})
   */
  public function startAction($quiz_id)
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $em   = $this->getDoctrine()->getEntityManager();
    $qm   = $this->get('quiz.manager');
    $qum  = $this->get('question.manager');
    $uqm  = $this->get('user_quiz.manager');
    
    /**
     * @todo validate $quiz_id
     */

    $quiz      = $qm->find($quiz_id);
    $questions = $qum->getRandomQuestionsForQuiz($quiz, 3);
    
    /**
     * Creating UserQuiz
     */
    $user_quiz = $uqm->getActiveQuizForUser($user);
    if (!$user_quiz)
    {
      $user_quiz = $uqm->create($user, $quiz, $questions, $em);
    }
    
    return array(
      'quiz'      => $quiz,
      'user_quiz' => $user_quiz,
    );
    
  }
  
  /**
   * Start new quiz for current user
   * @Route("/question/{uq_id}/{number}", name="quiz_go")
   * @Template("SmirikQuizBundle:Quiz:question.html.twig", vars={"get"})
   */
  public function questionAction($uq_id, $number)
  {
    
    $user = $this->container->get('security.context')->getToken()->getUser();
    $em   = $this->getDoctrine()->getEntityManager();
    $qm   = $this->get('quiz.manager');
    $qum  = $this->get('question.manager');
    $uqm  = $this->get('user_quiz.manager');
    
    $user_quiz = $uqm->find($uq_id);
    /**
     * @todo validate $uq_id
     * @todo validate time
     */
    
    $questions = json_decode($user_quiz->getQuestions());
    $number = (int)$number;
    if (($number >= count($questions)) || ($number < 0))
    {
      /**
       * @todo Exception
       */
      die('Error');
    }
    
    $question = $qum->find($questions[$number]);
    
    return array(
      'user_quiz' => $user_quiz,
      'question'  => $question,
      'number'    => $number,
      'total'     => count($questions),
    );
    
  }
  
  /**
   * Check user answer
   * @Route("/question/check", name="quiz_check")
   * @Method("post")
   */
  public function checkQuestionAction()
  {
    var_dump('Stop check');
    exit();
  }
  
}