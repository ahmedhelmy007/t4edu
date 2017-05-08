<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\CccCcc;
use Tatweer\TrainingBundle\Form\CccCccType;

/**
 * CccCcc controller.
 *
 * @Route("/cccccc")
 */
class CccCccController extends Controller
{

    /**
     * Lists all CccCcc entities.
     *
     * @Route("/", name="cccccc")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:CccCcc')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CccCcc entity.
     *
     * @Route("/", name="cccccc_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:CccCcc:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CccCcc();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cccccc_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CccCcc entity.
     *
     * @param CccCcc $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CccCcc $entity)
    {
        $form = $this->createForm(new CccCccType(), $entity, array(
            'action' => $this->generateUrl('cccccc_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CccCcc entity.
     *
     * @Route("/new", name="cccccc_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CccCcc();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CccCcc entity.
     *
     * @Route("/{id}", name="cccccc_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:CccCcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CccCcc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CccCcc entity.
     *
     * @Route("/{id}/edit", name="cccccc_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:CccCcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CccCcc entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CccCcc entity.
    *
    * @param CccCcc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CccCcc $entity)
    {
        $form = $this->createForm(new CccCccType(), $entity, array(
            'action' => $this->generateUrl('cccccc_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CccCcc entity.
     *
     * @Route("/{id}", name="cccccc_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:CccCcc:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:CccCcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CccCcc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cccccc_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CccCcc entity.
     *
     * @Route("/{id}", name="cccccc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:CccCcc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CccCcc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cccccc'));
    }

    /**
     * Creates a form to delete a CccCcc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cccccc_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
