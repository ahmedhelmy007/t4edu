<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\EvaluationPeriods;
use Tatweer\TrainingBundle\Form\EvaluationPeriodsType;

/**
 * EvaluationPeriods controller.
 *
 * @Route("/periods")
 */
class EvaluationPeriodsController extends Controller
{
    
    protected $translator;
    
    /**
     * 
     */
    public function __construct($translator =null) {
   $this->translator = $translator;
}
    /**
     * Lists all EvaluationPeriods entities.
     *
     * @Route("/", name="periods")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->findAll();
        
        $deleteForms = array();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }

        return array(
            'entities' => $entities,
            'deleteForms' => $deleteForms,
            'pageSubTitle' => $this->get('translator')->trans('Evaluation Periods list' , array() , 'periods')

        );
    }
    /**
     * Creates a new EvaluationPeriods entity.
     *
     * @Route("/", name="_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:EvaluationPeriods:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EvaluationPeriods();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Add new evaluation period' , array() , 'periods')
        );
    }

    /**
     * Creates a form to create a EvaluationPeriods entity.
     *
     * @param EvaluationPeriods $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EvaluationPeriods $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new EvaluationPeriodsType($translator), $entity, array(
            'action' => $this->generateUrl('_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EvaluationPeriods entity.
     *
     * @Route("/new", name="_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        //$translator = $this->get('translator');
        //echo $translator->trans('Start date');
        //echo  $this->get('translator')->trans('periods.Evaluation period main data');
        $entity = new EvaluationPeriods();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Add new evaluation period' , array() , 'periods')
        );
    }

    /**
     * Finds and displays a EvaluationPeriods entity.
     *
     * @Route("/{id}", name="_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvaluationPeriods entity.');
        }
        $datetime1 = date_create($entity->getStartDate());
        $datetime2 = date_create($entity->getEndDate());
        $interval = date_diff($datetime1, $datetime2);
        $entity->durationInMoths = $interval->format('%m');
        
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('View details' , array() , 'messages')

        );
    }

    /**
     * Displays a form to edit an existing EvaluationPeriods entity.
     *
     * @Route("/{id}/edit", name="_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvaluationPeriods entity.');
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
    * Creates a form to edit a EvaluationPeriods entity.
    *
    * @param EvaluationPeriods $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EvaluationPeriods $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new EvaluationPeriodsType($translator), $entity, array(
            'action' => $this->generateUrl('_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EvaluationPeriods entity.
     *
     * @Route("/{id}", name="_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:EvaluationPeriods:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EvaluationPeriods entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Item successfully edited')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EvaluationPeriods entity.
     *
     * @Route("/{id}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EvaluationPeriods entity.');
            }
            $repository = $this->getDoctrine()
                    ->getRepository('TatweerTrainingBundle:EmployeesEvaluations');

            $associatedEvaluations = $repository->createQueryBuilder('DB')
                    ->where('DB.evaluationPeriod = :evaluation_period_id')
                    ->setParameter( 'evaluation_period_id', $id)
                    ->getQuery()
                    ->getResult();
            
            if($associatedEvaluations){
                $this->get('session')->getFlashBag()->add('alert-error', $this->get('translator')
                        ->trans('Selected evaluation period has evaluations for employees, you couldn’t delete it.', 
                                array(), 'periods'));
            }else{
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Item successfully deleted'));
            }
        }

        return $this->redirect($this->generateUrl(''));
    }

    /**
     * Creates a form to delete a EvaluationPeriods entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class'=>'delete-item')))
            ->getForm()
        ;
    }
}
