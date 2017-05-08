<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\DemoBundle\Entity\Budgets;
use Acme\DemoBundle\Form\BudgetsType;

/**
 * Budgets controller.
 *
 * @Route("/budgets")
 */
class BudgetsController extends Controller
{

    /**
     * Lists all Budgets entities.
     *
     * @Route("/", name="budgets")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeDemoBundle:Budgets')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Budgets entity.
     *
     * @Route("/", name="budgets_create")
     * @Method("POST")
     * @Template("AcmeDemoBundle:Budgets:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Budgets();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('budgets_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Budgets entity.
     *
     * @param Budgets $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Budgets $entity)
    {
        $form = $this->createForm(new BudgetsType(), $entity, array(
            'action' => $this->generateUrl('budgets_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Budgets entity.
     *
     * @Route("/new", name="budgets_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Budgets();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Budgets entity.
     *
     * @Route("/{id}", name="budgets_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDemoBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Budgets entity.
     *
     * @Route("/{id}/edit", name="budgets_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDemoBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
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
    * Creates a form to edit a Budgets entity.
    *
    * @param Budgets $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Budgets $entity)
    {
        $form = $this->createForm(new BudgetsType(), $entity, array(
            'action' => $this->generateUrl('budgets_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Budgets entity.
     *
     * @Route("/{id}", name="budgets_update")
     * @Method("PUT")
     * @Template("AcmeDemoBundle:Budgets:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeDemoBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('budgets_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Budgets entity.
     *
     * @Route("/{id}", name="budgets_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeDemoBundle:Budgets')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Budgets entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('budgets'));
    }

    /**
     * Creates a form to delete a Budgets entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('budgets_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
