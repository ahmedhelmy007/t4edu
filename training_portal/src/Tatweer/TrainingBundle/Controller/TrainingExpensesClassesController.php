<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\TrainingExpensesClasses;
use Tatweer\TrainingBundle\Form\TrainingExpensesClassesType;

/**
 * TrainingExpensesClasses controller.
 *
 * @Route("/trainingexpensesclasses")
 */
class TrainingExpensesClassesController extends Controller
{

    /**
     * Lists all TrainingExpensesClasses entities.
     *
     * @Route("/", name="trainingexpensesclasses")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findAll();
        foreach ($entities as $k => $v)
        {
            if($em->getRepository('TatweerTrainingBundle:TrainingExpenses')->findByExpenseClass($v->getIdClass()))
            $entities[$k]->canDeleted= 0;
            else 
            $entities[$k]->canDeleted= 1;    
          
        }

        return array(
            'entities' => $entities,
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes list' , array() , 'trainingexpensesclasses')

        );
    }
    /**
     * Creates a new TrainingExpensesClasses entity.
     *
     * @Route("/", name="trainingexpensesclasses_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:TrainingExpensesClasses:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TrainingExpensesClasses();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('trainingexpensesclasses'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes creation' , array() , 'trainingexpensesclasses')
        );
    }

    /**
     * Creates a form to create a TrainingExpensesClasses entity.
     *
     * @param TrainingExpensesClasses $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TrainingExpensesClasses $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new TrainingExpensesClassesType($translator), $entity, array(
            'action' => $this->generateUrl('trainingexpensesclasses_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TrainingExpensesClasses entity.
     *
     * @Route("/new", name="trainingexpensesclasses_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TrainingExpensesClasses();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes creation' , array() , 'trainingexpensesclasses')
        );
    }

    /**
     * Finds and displays a TrainingExpensesClasses entity.
     *
     * @Route("/{id}", name="trainingexpensesclasses_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingExpensesClasses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes view' , array() , 'trainingexpensesclasses')

        );
    }

    /**
     * Displays a form to edit an existing TrainingExpensesClasses entity.
     *
     * @Route("/{id}/edit", name="trainingexpensesclasses_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingExpensesClasses entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes edit' , array() , 'trainingexpensesclasses')
        );
    }

    /**
    * Creates a form to edit a TrainingExpensesClasses entity.
    *
    * @param TrainingExpensesClasses $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TrainingExpensesClasses $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new TrainingExpensesClassesType($translator), $entity, array(
            'action' => $this->generateUrl('trainingexpensesclasses_update', array('id' => $entity->getIdClass())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TrainingExpensesClasses entity.
     *
     * @Route("/{id}", name="trainingexpensesclasses_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:TrainingExpensesClasses:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingExpensesClasses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('trainingexpensesclasses'));

        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Training expenses classes edit' , array() , 'trainingexpensesclasses')
        );
    }
    /**
     * Deletes a TrainingExpensesClasses entity.
     *
     * @Route("/delete/{id}", name="trainingexpensesclasses_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TrainingExpensesClasses entity.');
            }

            $em->remove($entity);
            $em->flush();
            
        

            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error
        }
            return $this->redirect($this->generateUrl('trainingexpensesclasses'));
    }

    /**
     * Creates a form to delete a TrainingExpensesClasses entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trainingexpensesclasses_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
