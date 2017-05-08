<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Preferences;
use Tatweer\TrainingBundle\Form\PreferencesType;

/**
 * Preferences controller.
 *
 * @Route("/preferences")
 */
class PreferencesController extends Controller
{

    /**
     * Lists all Preferences entities.
     *
     * @Route("/", name="preferences")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Preferences:edit.html.twig")
     */
    public function indexAction()
    {
    
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Preferences')->findAll();
        $entity = $entity[0];
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preferences entity.');
        }

        $editForm = $this->createEditForm($entity);
  

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Preferences' , array() , 'preferences')
      
        );
 
    }


    /**
    * Creates a form to edit a Preferences entity.
    *
    * @param Preferences $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Preferences $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new PreferencesType($translator), $entity, array(
            'action' => $this->generateUrl('preferences_update', array('id' => $entity->getIdPreferences())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Preferences entity.
     *
     * @Route("/{id}", name="preferences_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Preferences:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Preferences')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preferences entity.');
        }

    
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('preferences'));

        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
       
        );
    }



}
