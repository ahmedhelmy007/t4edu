<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\DepartmentBudgets;
use Tatweer\TrainingBundle\Form\DepartmentBudgetsType;

/**
 * DepartmentBudgets controller.
 *
 * @Route("/departmentbudgets")
 */
class DepartmentBudgetsController extends Controller
{

    /**
     * Lists all DepartmentBudgets entities.
     *
     * @Route("/", name="departmentbudgets")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DepartmentBudgets entity.
     *
     * @Route("/", name="departmentbudgets_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:DepartmentBudgets:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DepartmentBudgets();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('departmentbudgets_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a DepartmentBudgets entity.
     *
     * @param DepartmentBudgets $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DepartmentBudgets $entity)
    {
        $form = $this->createForm(new DepartmentBudgetsType(), $entity, array(
            'action' => $this->generateUrl('departmentbudgets_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DepartmentBudgets entity.
     *
     * @Route("/new", name="departmentbudgets_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DepartmentBudgets();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a DepartmentBudgets entity.
     *
     * @Route("/{id}", name="departmentbudgets_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DepartmentBudgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DepartmentBudgets entity.
     *
     * @Route("/{id}/edit", name="departmentbudgets_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DepartmentBudgets entity.');
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
    * Creates a form to edit a DepartmentBudgets entity.
    *
    * @param DepartmentBudgets $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DepartmentBudgets $entity)
    {
        $form = $this->createForm(new DepartmentBudgetsType(), $entity, array(
            'action' => $this->generateUrl('departmentbudgets_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DepartmentBudgets entity.
     *
     * @Route("/{id}", name="departmentbudgets_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:DepartmentBudgets:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DepartmentBudgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('departmentbudgets_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a DepartmentBudgets entity.
     *
     * @Route("/{id}", name="departmentbudgets_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DepartmentBudgets entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('departmentbudgets'));
    }

    /**
     * Creates a form to delete a DepartmentBudgets entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('departmentbudgets_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
