<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\AaaAaa;
use Tatweer\TrainingBundle\Form\AaaAaaType;

/**
 * AaaAaa controller.
 *
 * @Route("/aaa")
 */
class AaaAaaController extends Controller
{

    /**
     * Lists all AaaAaa entities.
     *
     * @Route("/", name="aaaaaa")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:AaaAaa')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AaaAaa entity.
     *
     * @Route("/", name="aaaaaa_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:AaaAaa:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AaaAaa();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aaaaaa_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AaaAaa entity.
     *
     * @param AaaAaa $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AaaAaa $entity)
    {
        $form = $this->createForm(new AaaAaaType(), $entity, array(
            'action' => $this->generateUrl('aaaaaa_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AaaAaa entity.
     *
     * @Route("/new", name="aaaaaa_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AaaAaa();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AaaAaa entity.
     *
     * @Route("/{id}", name="aaaaaa_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:AaaAaa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AaaAaa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AaaAaa entity.
     *
     * @Route("/{id}/edit", name="aaaaaa_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:AaaAaa')->find($id);
        $entities = $em->getRepository('TatweerTrainingBundle:AaaAaa')->findAll();
        $bbbBbbEntities = $em->getRepository('TatweerTrainingBundle:BbbBbb')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AaaAaa entity.');
        }

        //$editForm = $this->createEditForm($entity);
        $editForm = $this->createForm(new AaaAaaType(array('bbbBbbEntities' => $bbbBbbEntities, 'aaaAaa' => $entity)), $entity);
        $form = $this->createForm(new AaaAaaType(), new AaaAaa());
        
        $deleteForm = $this->createDeleteForm($id);
        
        if ($request->getMethod() == 'POST') {
            $editForm->bind($request);
            $getRentalPeriods = $entity->getAaaBbbCccCollection();
            // validate the entity and return the validation errors in notice
            $errorMsg = "";
            $errors = $this->container->get('validator')->validate($entity);
            
            //
            // TODO: COMPLETE CODE HERE
            //
            
        }
        
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'entities' => $entities,
            'bbbBbbEntities' => $bbbBbbEntities
        );
    }

    /**
    * Creates a form to edit a AaaAaa entity.
    *
    * @param AaaAaa $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AaaAaa $entity)
    {
        $form = $this->createForm(new AaaAaaType(), $entity, array(
            'action' => $this->generateUrl('aaaaaa_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AaaAaa entity.
     *
     * @Route("/{id}", name="aaaaaa_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:AaaAaa:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:AaaAaa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AaaAaa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('aaaaaa_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AaaAaa entity.
     *
     * @Route("/{id}", name="aaaaaa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:AaaAaa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AaaAaa entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aaaaaa'));
    }

    /**
     * Creates a form to delete a AaaAaa entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aaaaaa_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
