<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Trainings;
use Tatweer\TrainingBundle\Form\TrainingsType;
use Tatweer\TrainingBundle\Entity\TrainingNeeds;
use Tatweer\TrainingBundle\Entity\TrainingNeedsValues;
use Tatweer\TrainingBundle\Entity\TrainingExpenses;
use Tatweer\TrainingBundle\Entity\TrainingExpensesClasses;
/**
 * Trainings controller.
 *
 * @Route("/trainings")
 */
class TrainingsController extends Controller
{

    /**
     * Lists all Trainings entities.
     *
     * @Route("/", name="trainings")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /*$em = $this->getDoctrine()->getManager();
            $trainingExpense = new TrainingExpenses();
            //$expenseClass    = new TrainingExpensesClasses();
            
            $expenseClass = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find(1);
            $expenseClassE = $em->getRepository('TatweerTrainingBundle:TrainingExpenses')->findByTraining(42);
            echo "<pre>";
            \Doctrine\Common\Util\Debug::Dump($expenseClassE);
            echo "</pre>";

             
            $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find(41);
            
            // set training Expenses
            $trainingExpense->setExpenseClass($expenseClass);
            $trainingExpense->setTraining($entity);
            $trainingExpense->setValue(22);
            $em->persist($trainingExpense);
            $em->flush();*/
            
            
       /* $entities = $em->getRepository('TatweerTrainingBundle:Trainings')->findAll();

        return array(
            'entities' => $entities,
        );*/
    }
    /**
     * Creates a new Trainings entity.
     *
     * @Route("/{groupid}/{userid}/", name="trainings_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Trainings:new.html.twig")
     */
    public function createAction(Request $request ,  $groupid , $userid )
    {   
        $em = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();

        $entity                = new Trainings();

        
        $form = $this->createCreateForm($entity ,  $groupid , $userid );
        $form->handleRequest($request);

        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $CreatedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        if ($form->isValid()) {
            $this->saveData($params , $entity , $CreatedByObj);
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('_usertrainingdetails', array('groupid' => $groupid , 'userid'=>$userid  )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    private function saveData($params , Trainings $entity , $CreatedByObj)
    {
            $em = $this->getDoctrine()->getManager();
            // to fix “Call to a member function format() on a non-object” error 
            //$entity->setStartDate(new \DateTime($entity->getStartDate()));
           // $entity->setEndDate(new \DateTime($entity->getEndDate()));
            
            if(isset($params['languageOther']))
            {
            $entity->setLanguageOther($params['languageOther']);
            //$entity->setLanguage(NULL);
            }
            $entity->setCreatedBy($CreatedByObj);
            $em->persist($entity);
            $em->flush();
 
           
           foreach ($params['other'] as $k => $v)
           {
            if($v && $params['other_values'][$k])
               {
            $trainingExpense = new TrainingExpenses();
            $expenseClass    = new TrainingExpensesClasses();
            
            $expenseClass = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($v);
        
            //echo $entity->getCountry();
            // set training Expenses
            $trainingExpense->setExpenseClass($expenseClass);
            $trainingExpense->setTraining($entity);
            $trainingExpense->setValue($params['other_values'][$k]);
            $em->persist($trainingExpense);
            $em->flush();
               }
           }
    }

    /**
     * Creates a form to create a Trainings entity.
     *
     * @param Trainings $entity The entity
     * 
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Trainings $entity ,  $groupid , $userid )
    {
        $request           = $this->getRequest();
        $em                = $this->getDoctrine()->getManager();
        $trainingNeed      = new TrainingNeeds();
        
        
      if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
           else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
        
        
        $trainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->findBy(array('requestedForEmployee'=> $userid , 'employeeGroup'=> $groupid , 'trainingneedPeriod' => $trainingNeedPeriodId));

        $translator = $this->get('translator');
        $form = $this->createForm(new TrainingsType($translator,$this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('trainings_create', array('groupid' => $groupid , 'userid' => $userid )),
            'method' => 'POST',
            'locale'  => $request->getLocale(),
            'trainingNeedId'  => $trainingNeed[0]->getIdNeed(),
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Trainings entity.
     *
     * @Route("/{groupid}/{userid}/new", name="trainings_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction( $groupid , $userid )
    {
        $entity = new Trainings();
        $form   = $this->createCreateForm($entity , $groupid , $userid );
        $em     = $this->getDoctrine()->getManager();

        $nonManagableCostItems      = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findBy(array('manageable' => 0 , 'active' => 1));
        $managableCostItems      = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findBy(array('manageable' => 1 , 'active' => 1));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'nonManagableCostItems' => $nonManagableCostItems,
            'managableCostItems' => $managableCostItems,
            
        );
    }

    /**
     * Finds and displays a Trainings entity.
     *
     * @Route("/{id}", name="trainings_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $canManage = false;
        $entity           = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserTrainingById($id);
        $trainingExpenses = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingExpenses($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
        }

        if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,8,9) )) // is Training Department Responsible or Training manager  , HR Manager
        {
            $canManage = true; // he can update the training need request to add SUGGESTED TRAINING PROGRAMS (From HR)
        }

        return array(
            'entity'           => $entity,
            'trainingExpenses' => $trainingExpenses ,
            'canManage'        => $canManage
           
        );
    }

    /**
     * Displays a form to edit an existing Trainings entity.
     *
     * @Route("/{id}/edit", name="trainings_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
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
    * Creates a form to edit a Trainings entity.
    *
    * @param Trainings $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Trainings $entity)
    {
        $request           = $this->getRequest();
        $em                = $this->getDoctrine()->getManager();
        $trainingNeedValues= new TrainingNeedsValues();
        $trainingNeed      = new TrainingNeeds();
        
        $trainingNeedValues= $em->getRepository('TatweerTrainingBundle:TrainingNeedsValues')->find($entity->getTrainingNeedsProgram());
        $trainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingNeedValues->getTrainingNeed());
        
        $translator = $this->get('translator');
        $form = $this->createForm(new TrainingsType($translator,$this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('trainings_update', array('id' => $entity->getIdTraining())),
            'method' => 'PUT',
            'locale'  => $request->getLocale(),
            'trainingNeedId'  => $trainingNeed->getIdNeed(),
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Trainings entity.
     *
     * @Route("/{id}", name="trainings_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Trainings:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('trainings_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Trainings entity.
     *
     * @Route("/delete/{id}", name="trainings_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
 
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);
            $entityExpensesClasses = $em->getRepository('TatweerTrainingBundle:TrainingExpenses')->findByTraining($id);
            $trainingNeeds         = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingNeedByTraining($id);
            
            
            $groupid = $trainingNeeds->getEmployeeGroup()->getIdGroup();
            $userid  = $trainingNeeds->getRequestedForEmployee()->getIdUser();
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trainings entity.');
            }
            foreach ($entityExpensesClasses as $k => $v)
            $em->remove($v);
            $em->flush();
            $em->remove($entity);
            $em->flush();


        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error
        }
        
        return $this->redirect($this->generateUrl('_usertrainingdetails', array('groupid' => $groupid  , 'userid' =>  $userid)));
    }

    /**
     * Creates a form to delete a Trainings entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trainings_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
