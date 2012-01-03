<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
  * @Route("/", name="smirik_quiz_index")
  * @Template("SmirikQuizBundle:Quiz:index.html.twig")
  */
  public function indexAction()
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $uqm  = $this->get('user_quiz.manager');
    
    $active_quiz = $uqm->getAllActiveQuizForUser($user, true, $this->getDoctrine()->getEntityManager());
    /**
     * Get quiz ids for active quizes
     */
    $active_quiz_ids = array();
    if ($active_quiz)
    {
      foreach ($active_quiz as $quiz)
      {
        $active_quiz_ids[] = $quiz->getQuizId();
      }
    }
    
    $avaliable_quiz = $this->get('quiz.manager')->getAvaliableQuizes($user);
    $completed_users_quiz = $uqm->getAllCompletedQuizForUser($user);
    
    return array(
      'users_quiz'      => $active_quiz,
      'active_quiz_ids' => $active_quiz_ids,
      'avaliable_quiz'  => $avaliable_quiz,
      'completed_users_quiz'  => $completed_users_quiz,
    );
  }

  /**
   * List of active quized
   * @Route("/my", name="smirik_quiz_my")
   * @Template("SmirikQuizBundle:Quiz:my.html.twig", vars={"get"})
   */
  public function myAction()
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $uqm  = $this->get('user_quiz.manager');
    
    $active_quiz = $uqm->getAllActiveQuizForUser($user, true, $this->getDoctrine()->getEntityManager());
    /**
     * Get quiz ids for active quizes
     */
    $active_quiz_ids = array();
    if ($active_quiz)
    {
      foreach ($active_quiz as $quiz)
      {
        $active_quiz_ids[] = $quiz->getQuizId();
      }
    }
    
    $avaliable_quiz = $this->get('quiz.manager')->getAvaliableQuizes($user);
    $completed_users_quiz = $uqm->getAllCompletedQuizForUser($user);
    
    return array(
      'users_quiz'      => $active_quiz,
      'active_quiz_ids' => $active_quiz_ids,
      'avaliable_quiz'  => $avaliable_quiz,
      'completed_users_quiz'  => $completed_users_quiz,
    );
  }

  /**
   * Start new quiz for current user
   * @Route("/start/{quiz_id}", name="smirik_quiz_start")
   * @Template("SmirikQuizBundle:Quiz:start.html.twig", vars={"get"})
   */
  public function startAction($quiz_id)
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $uqm  = $this->get('user_quiz.manager');

    /**
     * @todo validate $quiz_id
     */
    $quiz      = $this->get('quiz.manager')->find($quiz_id);
    $questions = $this->get('question.manager')->getRandomQuestionsForQuiz($quiz, $quiz->getNumQuestions());

    /**
     * Redirect to home if quiz is not opened
     */
    if (!$quiz->getIsOpened()) 
    {
      return $this->redirect($this->generateUrl('smirik_quiz_index'));
    }
    /**
     * Creating UserQuiz
     */
    $user_quiz = $uqm->getActiveQuizForUser($user, $quiz);
    if (!$user_quiz)
    {
      $user_quiz = $uqm->create($user, $quiz, $questions, $this->getDoctrine()->getEntityManager());
    }

    return array(
      'quiz'      => $quiz,
      'user_quiz' => $user_quiz,
    );

  }

  /**
   * Start new quiz for current user
   * @Route("/question/quiz{uq_id}/step{number}", name="smirik_quiz_go")
   * @Template("SmirikQuizBundle:Quiz:question.html.twig", vars={"get"})
   */
  public function questionAction($uq_id, $number)
  {

    $user = $this->container->get('security.context')->getToken()->getUser();
    $uqm  = $this->get('user_quiz.manager');

    $user_quiz = $uqm->find($uq_id);
    if (!$user_quiz)
    {
      throw $this->createNotFoundException('UserQuiz not found');
    }
    /**
     * @todo validate $uq_id
     * @todo validate time
     */

    $questions = json_decode($user_quiz->getQuestions());
    $number = (int)$number;
    if (($number > count($questions)) || ($number < 0) || (empty($questions)))
    {
      /**
       * @todo Exception
       */
      throw new \Exception('Bad quiz data');
    }

    $question = $this->get('question.manager')->find($questions[$number]);

    /**
     * Find UserQuestion for current question (to provide default answer value)
     */
    $user_question = $this->get('user_question.manager')->findByUserQuiz($user_quiz, $question);
    if ($user_question)
    {
      $current_answer = $user_question->getAnswerId();
    } else
    {
      $current_answer = false;
    }
    
    $answers = $question->getAnswers();
    
    return array(
      'user_quiz' => $user_quiz,
      'quiz'      => $user_quiz->getQuiz(),
      'question'  => $question,
      'number'    => $number,
      'total'     => count($questions),
      'current_answer' => $current_answer,
      'answers'   => $answers,
      'num_answers' => count($answers),
    );

  }

  /**
   * Check user answer
   * @Route("/question/check", name="smirik_quiz_check")
   * @Method("post")
   */
  public function checkQuestionAction(Request $request)
  {
    $user_quiz_id = $this->getRequest()->request->get('user_quiz_id', false);
    $question_id  = $this->getRequest()->request->get('question_id', false);
    $answer_id    = $this->getRequest()->request->get('answer_id', false); 
    $answer_text  = $this->getRequest()->request->get('answer_text', false); 
    $number       = $this->getRequest()->request->get('number', false); 

    if ((!$user_quiz_id) || (!$question_id) || (!$answer_id))
    {
      throw $this->createNotFoundException('Error in application: no required parameters');
    }

    $user = $this->container->get('security.context')->getToken()->getUser();
    $em   = $this->getDoctrine()->getEntityManager();

    $user_quiz = $this->get('user_quiz.manager')->find($user_quiz_id);
    $quiz      = $user_quiz->getQuiz();
    
    if (!$user_quiz)
    {
      throw $this->createNotFoundException('Quiz for current user not found');
    }

    if (!$user_quiz->isActiveForUser($user))
    {
      throw new \Exception('Quiz already ended');
    }
    
    $answer = $this->get('answer.manager')->find($answer_id);
    if (!$answer)
    {
      throw $this->createNotFoundException('Answer not found');
    }
    
    $question = $this->get('question.manager')->find($question_id);
    if (!$question)
    {
      throw $this->createNotFoundException('Question not found');
    }
    
    /**
     * Find answer for current question or create new UserQuestion
     * and add/replace answer
     */
    $user_question = $this->get('user_question.manager')->findOrCreate($user_quiz, $question, $em);
    $user_question->addAnswer($answer, $em, $answer_text);
    
    /**
     * Increment current position in quiz. If this question is the last one redirect to end page.
     */
    if (($number + 1) == $quiz->getNumQuestions())
    {
      return $this->redirect($this->generateUrl('smirik_quiz_prefinal', array('user_quiz_id' => $user_quiz->getId())));
    }
    
    $user_quiz->setCurrent($number+1);
    $em->persist($user_quiz);
    $em->flush();
    
    return $this->redirect($this->generateUrl('smirik_quiz_go', array('uq_id' => $user_quiz->getId(), 'number' => $user_quiz->getCurrent())));

  }

  /**
   * Page before end
   * @Route("/question/quiz{user_quiz_id}/prefinal", name="smirik_quiz_prefinal")
   * @Template("SmirikQuizBundle:Quiz:prefinal.html.twig", vars={"get"})
   */
  public function preFinalAction($user_quiz_id)
  {
    $user_quiz = $this->get('user_quiz.manager')->find($user_quiz_id);
    if (!$user_quiz)
    {
      throw $this->createNotFoundException('UserQuiz not found');
    }
    
    if ($user_quiz->getIsClosed())
    {
      return $this->redirect($this->generateUrl('smirik_quiz_index'));
    }
    
    return array(
      'user_quiz' => $user_quiz,
    );
  }
  
  /**
   * Final page
   * @Route("/question/quiz{user_quiz_id}/final", name="smirik_quiz_final")
   * @Template("SmirikQuizBundle:Quiz:final.html.twig", vars={"get"})
   */
  public function finalAction($user_quiz_id)
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $em   = $this->getDoctrine()->getEntityManager();
    
    /**
     * Closing UserQuiz
     */
    $user_quiz = $this->get('user_quiz.manager')->find($user_quiz_id);
    if (!$user_quiz)
    {
      throw $this->createNotFoundException('UserQuiz not found');
    }
    
    if (!$user_quiz->getIsClosed())
    {
      $user_quiz->close();
      $em->persist($user_quiz);
      $em->flush();
    }
    
    return array(
      'user_quiz' => $user_quiz,
    );
  }
  
}
