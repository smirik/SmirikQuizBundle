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
  * @Route("/index", name="quiz_index")
  * @Template("SmirikQuizBundle:Quiz:index.html.twig")
  */
  public function indexAction()
  {
  }
  
}