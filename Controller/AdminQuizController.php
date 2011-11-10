<?php

namespace Smirik\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Smirik\QuizBundle\Entity\Quiz;
use Smirik\QuizBundle\Form\QuizType;

/**
 * Quiz controller.
 *
 * @Route("/admin/quiz")
 */
class AdminQuizController extends Controller
{
  
  /**
  * Finds and displays a Quiz entity.
  *
  * @Route("/users", name="smirik_quiz_admin_quiz_users")
  * @Template("SmirikQuizBundle:Admin\Quiz:users.html.twig")
  */
  public function usersAction()
  {
    $user_manager = $this->get('fos_user.user_manager');
    $users = $user_manager->findUsers();
    return array(
      'users' => $users,
    );
  }
  
  /**
  * Lists all Quiz entities.
  *
  * @Route("/", name="smirik_quiz_admin_quiz")
  * @Template("SmirikQuizBundle:Admin\Quiz:index.html.twig", vars={"get"})
  */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $entities = $em->getRepository('SmirikQuizBundle:Quiz')->findAll();

    return array('entities' => $entities);
  }

  /**
  * Finds and displays a Quiz entity.
  *
  * @Route("/{id}/show", name="smirik_quiz_admin_quiz_show")
  * @Template("SmirikQuizBundle:Admin\Quiz:show.html.twig", vars={"get"})
  */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('SmirikQuizBundle:Quiz')->find($id);

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find Quiz entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
        'entity'      => $entity,
        'delete_form' => $deleteForm->createView(), );
  }

  /**
  * Displays a form to create a new Quiz entity.
  *
  * @Route("/new", name="smirik_quiz_admin_quiz_new")
  * @Template("SmirikQuizBundle:Admin\Quiz:new.html.twig", vars={"get"})
  */
  public function newAction()
  {
    $entity = new Quiz();
    $form   = $this->createForm(new QuizType(), $entity);

    return array(
        'entity' => $entity,
        'form'   => $form->createView()
    );
  }

  /**
  * Creates a new Quiz entity.
  *
  * @Route("/create", name="smirik_quiz_admin_quiz_create")
  * @Method("post")
  * @Template("SmirikQuizBundle:Admin\Quiz:new.html.twig", vars={"post"})
  */
  public function createAction()
  {
    $entity  = new Quiz();
    $request = $this->getRequest();
    $form    = $this->createForm(new QuizType(), $entity);
    $form->bindRequest($request);

    if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('smirik_quiz_admin_quiz_edit', array('id' => $entity->getId())));
      
    }

    return array(
        'entity' => $entity,
        'form'   => $form->createView()
    );
  }

  /**
  * Displays a form to edit an existing Quiz entity.
  *
  * @Route("/{id}/edit", name="smirik_quiz_admin_quiz_edit")
  * @Template("SmirikQuizBundle:Admin\Quiz:edit.html.twig", vars={"get"})
  */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('SmirikQuizBundle:Quiz')->find($id);

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find Quiz entity.');
    }

    $editForm = $this->createForm(new QuizType(), $entity);
    $deleteForm = $this->createDeleteForm($id);

    return array(
        'entity'      => $entity,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
  * Edits an existing Quiz entity.
  *
  * @Route("/{id}/update", name="smirik_quiz_admin_quiz_update")
  * @Method("post")
  * @Template("SmirikQuizBundle:Admin\Quiz:edit.html.twig")
  */
  public function updateAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $entity = $em->getRepository('SmirikQuizBundle:Quiz')->find($id);

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find Quiz entity.');
    }

    $editForm   = $this->createForm(new QuizType(), $entity);
    $deleteForm = $this->createDeleteForm($id);

    $request = $this->getRequest();

    $editForm->bindRequest($request);

    if ($editForm->isValid()) {
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('smirik_quiz_admin_quiz_edit', array('id' => $id)));
    }

    return array(
        'entity'      => $entity,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
  }

  /**
  * Deletes a Quiz entity.
  *
  * @Route("/{id}/delete", name="smirik_quiz_admin_quiz_delete")
  * @Method("post")
  */
  public function deleteAction($id)
  {
    $form = $this->createDeleteForm($id);
    $request = $this->getRequest();

    $form->bindRequest($request);

    if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('SmirikQuizBundle:Quiz')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quiz entity.');
        }

        $em->remove($entity);
        $em->flush();
    }

    return $this->redirect($this->generateUrl('smirik_quiz_admin_quiz'));
  }

  private function createDeleteForm($id)
  {
    return $this->createFormBuilder(array('id' => $id))
        ->add('id', 'hidden')
        ->getForm()
    ;
  }
}
