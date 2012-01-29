<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Smirik\QuizBundle\Entity\Question;
use Smirik\QuizBundle\Entity\Answer;
use Smirik\QuizBundle\Form\QuestionType;

/**
 * Question controller.
 *
 * @Route("/admin/questions")
 */
class AdminQuestionController extends Controller
{
    /**
     * Lists all Question entities.
     *
     * @Route("/", name="smirik_quiz_admin_questions")
     * @Template("SmirikQuizBundle:Admin\Question:index.html.twig", vars={"get"})
     */
    public function indexAction()
    {
      $quiz_id = (int)$this->getRequest()->query->get('quiz_id', false); 
      
      $em = $this->getDoctrine()->getEntityManager();
      
      if ($quiz_id)
      {
        $quiz     = $em->getRepository('SmirikQuizBundle:Quiz')->find($quiz_id);
        if (is_object($quiz))
        {
          $entities = $quiz->getQuestions();
        } else 
        {
          $entities = $em->getRepository('SmirikQuizBundle:Question')->findAll();
        }
      } else
      {
        $quiz     = false;
        $entities = false;
      }
      
      $quizes = $em->getRepository('SmirikQuizBundle:Quiz')->findAll();
      

      return array(
        'entities' => $entities,
        'quizes'   => $quizes,
        'quiz_id'  => $quiz_id,
        'quiz'     => $quiz,
      );
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/{id}/show", name="smirik_quiz_admin_questions_show")
     * @Template("SmirikQuizBundle:Admin\Question:show.html.twig", vars={"get"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SmirikQuizBundle:Question')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Question entity.
     *
     * @Route("/{quiz_id}/new", name="smirik_quiz_admin_questions_new")
     * @Template("SmirikQuizBundle:Admin\Question:new.html.twig", vars={"get"})
     */
    public function newAction($quiz_id)
    {
      $em = $this->getDoctrine()->getEntityManager();
      //$quiz_id = $this->getRequest()->query->get('quiz_id', false); 
      
      $entity = new Question();
      if ($quiz_id)
      {
        $quiz    = $em->getRepository('SmirikQuizBundle:Quiz')->find($quiz_id);
        $entity->addQuiz($quiz);
      }
      $form   = $this->createForm(new QuestionType(), $entity);

      return array(
        'entity'  => $entity,
        'form'    => $form->createView(),
        'quiz_id' => $quiz_id,
      );
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/create", name="smirik_quiz_admin_questions_create")
     * @Method("post")
     * @Template("SmirikQuizBundle:Admin\Question:new.html.twig", vars={"post"})
     */
    public function createAction()
    {
        $entity  = new Question();
        $request = $this->getRequest();
        $form    = $this->createForm(new QuestionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();
            
            /**
             * Create N answers
             */
            $num_answers = $entity->getNumAnswers();
            for ($i=0; $i<$num_answers; $i++)
            {
              $answer = new Answer();
              $answer->setQuestion($entity);
              $entity->addAnswer($answer);
            }
            
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('smirik_quiz_admin_questions_edit', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     * @Route("/{id}/edit", name="smirik_quiz_admin_questions_edit")
     * @Template("SmirikQuizBundle:Admin\Question:edit.html.twig", vars={"get"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SmirikQuizBundle:Question')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Question entity.');
        }

        $editForm = $this->createForm(new QuestionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Question entity.
     *
     * @Route("/{id}/update", name="smirik_quiz_admin_questions_update")
     * @Method("post")
     * @Template("SmirikQuizBundle:Admin\Question:edit.html.twig", vars={"post"})
     */
    public function updateAction($id)
    {
      $em = $this->getDoctrine()->getEntityManager();

      $entity = $em->getRepository('SmirikQuizBundle:Question')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Question entity.');
      }

      $editForm   = $this->createForm(new QuestionType(), $entity);
      $deleteForm = $this->createDeleteForm($id);
      $request = $this->getRequest();

      $editForm->bindRequest($request);
      if ($editForm->isValid()) {
        
        $entity->upload();
        $em->persist($entity);
        $em->flush();
        
        /**
         * Dealing with answers
         * @todo FIX BY STANDART WAY
         */
        $num_answers = $entity->getNumAnswers();
        $current     = count($entity->getAnswers());

        if ($num_answers > $current)
        {
          $diff = $num_answers-$current;
          for ($i=0; $i<$diff; $i++)
          {
            $answer = new Answer();
            $answer->setQuestion($entity);
            $entity->addAnswer($answer);
          }

          $em->persist($entity);
          $em->flush();
          
        } elseif ($num_answers < $current)
        {
          $diff = $num_answers;
          $i = 0;
          foreach ($entity->getAnswers() as $answer)
          {
            if ($i >= $diff)
            {
              $entity->getAnswers()->removeElement($answer);
              $em->remove($answer);
            }
            $i++;
          }
          $em->persist($entity);
          $em->flush();
        }

        return $this->redirect($this->generateUrl('smirik_quiz_admin_questions_edit', array('id' => $entity->getId())));
      }

      return array(
        'entity'      => $entity,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
      );
    }

    /**
     * Deletes a Question entity.
     *
     * @Route("/{id}/delete", name="smirik_quiz_admin_questions_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SmirikQuizBundle:Question')->find($id);
            
            $quiz_id = $entity->getFirstQuiz()->getId();
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Question entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('smirik_quiz_admin_questions', array('quiz_id' =>$quiz_id)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
