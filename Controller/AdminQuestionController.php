<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Smirik\QuizBundle\Entity\Question;
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
     * @Route("/", name="admin_questions")
     * @Template("SmirikQuizBundle:Admin\Question:index.html.twig", vars={"get"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SmirikQuizBundle:Question')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Question entity.
     *
     * @Route("/{id}/show", name="admin_questions_show")
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
     * @Route("/new", name="admin_questions_new")
     * @Template("SmirikQuizBundle:Admin\Question:new.html.twig", vars={"get"})
     */
    public function newAction()
    {
        $entity = new Question();
        $form   = $this->createForm(new QuestionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Question entity.
     *
     * @Route("/create", name="admin_questions_create")
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
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_questions_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     * @Route("/{id}/edit", name="admin_questions_edit")
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
     * @Route("/{id}/update", name="admin_questions_update")
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
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_questions_edit', array('id' => $id)));
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
     * @Route("/{id}/delete", name="admin_questions_delete")
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

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Question entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_questions'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
