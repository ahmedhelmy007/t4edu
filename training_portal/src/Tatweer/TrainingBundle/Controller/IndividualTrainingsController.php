<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Trainings;
use Tatweer\TrainingBundle\Form\TrainingsType;
use Tatweer\TrainingBundle\Form\IndividualTrainingsType;
use Tatweer\TrainingBundle\Entity\TrainingNeeds;
use Tatweer\TrainingBundle\Entity\TrainingNeedsValues;
use Tatweer\TrainingBundle\Entity\TrainingExpenses;
use Tatweer\TrainingBundle\Entity\TrainingExpensesClasses;
use Tatweer\TrainingBundle\Entity\DepartmentBudgets;
/**
 * Trainings controller.
 *
 * @Route("/individualtrainings")
 */
class IndividualTrainingsController extends Controller
{

    /**
     * Lists all IndividualTrainings entities.
     *
     * @Route("/", name="_requestindividualtraining")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->getSelfTrainings($CurrentLoggedInUserId);
        

        return array(
            'entities' => $entity,
            'pageSubTitle' => $this->get('translator')->trans('Request training' , array() , 'navbar')

          
        );
    }
    

    /**
     * Lists all IndividualTrainings requests.
     *
     * @Route("/requests", name="_individualtrainingrequests")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:list_requests.html.twig")
     */
    public function individualTrainingsRequestsAction()
    {
        $data_result = false;
        $em          = $this->getDoctrine()->getManager();

        if( $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getSelfTrainingsRequests(array(2,3)))
        {
            foreach ($data_result as $userKey => $user)
            {
                $AdUserData = $this->get('ad.serivce')->getUserResults(array('username' => $user['username']));
               
                $data_result[$userKey]['Title'] = $AdUserData->Title;
                $data_result[$userKey]['Email'] = $AdUserData->Email;
                
            }
        }
        
        return array(
            'data_result' => $data_result,
          
        );
    }
    

    /**
     * Lists all IndividualTrainings requests.
     *
     * @Route("/followup/requests", name="_followupindividualtrainingrequests")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:list_requests.html.twig")
     */
    public function followupIndividualTrainingsRequestsAction()
    {
        $data_result = false;
        $em          = $this->getDoctrine()->getManager();
        
        
        if($rolesList = $em->getRepository('TatweerTrainingBundle:Users')->getTrainerHrRolesAsArray( $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId() ))
        {
        
        if( $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getSelfTrainingsRequests( $rolesList , true ))
        {
            foreach ($data_result as $userKey => $user)
            {
                $AdUserData = $this->get('ad.serivce')->getUserResults(array('username' => $user['username']));
               
                $data_result[$userKey]['Title'] = $AdUserData->Title;
                $data_result[$userKey]['Email'] = $AdUserData->Email;
                
            }
        }
        }
        return array(
            'data_result' => $data_result,
          
        );
    }
    

    
    
    /**
     * Lists all IndividualTrainings requests for hr and trainer 
     *
     * @Route("/hr/requests", name="_individualtrainingrequests")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:index.html.twig")
     */
  /*  public function individualTrainingsRequestsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->getSelfTrainingsRequests(array(6,7,8,9));
        return array(
            'entities' => $entity,
          
        );
    }*/
    
    
    /**
     * Lists all IndividualTrainings entities.
     *
     * @Route("/new", name="_newindividualtraining")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:new.html.twig")
     */
    public function newIndividualRequestAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();
        //$CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $entity                = new Trainings();
        $session = $this->getRequest()->getSession();
       // in another controller for another request
        $CurrentLoggedInUsername = $session->get('username');
        
        $form = $this->createCreateIndividualForm($entity );
        $form->handleRequest($request);
        
        $nonManagableCostItems   = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findBy(array('manageable' => 0 , 'active' => 1));
        $managableCostItems      = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findBy(array('manageable' => 1 , 'active' => 1));
        
        $userEntity                      = $em->getRepository('TatweerTrainingBundle:Users')->findByUsername($CurrentLoggedInUsername);
        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $CurrentLoggedInUsername)); // get user data from ACTIVE DIRECTORY 
        $userDataFromAD->employeeGrade   = $userEntity[0]->getEmployeeGrade();
        
        
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $groupsEntity          = $em->getRepository('TatweerTrainingBundle:Users')->getEmployeeGroups($CurrentLoggedInUserId , array(5,3) );
 
    //    $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($CurrentLoggedInUserId ,  $groupid , null , false , true );

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'nonManagableCostItems' => $nonManagableCostItems,
            'managableCostItems'    => $managableCostItems,
            'userentity'            => $userDataFromAD,
            'groupList'             => $groupsEntity,
            
        );
  
    }
    /**
     * Creates a new Trainings entity.
     *
     * @Route("/", name="individualrequest_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:new.html.twig")
     */
    public function createIndividualRequestAction(Request $request )
    {   
        $em = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();

        $entity                = new Trainings();

        
        $form = $this->createCreateIndividualForm($entity);
        $form->handleRequest($request);

        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $CreatedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        
        if ($form->isValid()) {
            $this->saveIndividualRequestData($params , $entity , $CreatedByObj);
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('_requestindividualtraining'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    private function saveIndividualRequestData($params , Trainings $entity , $CreatedByObj)
    {
            $em = $this->getDoctrine()->getManager();

            $trainingNeed = new TrainingNeeds();
            
            if(isset($params['group']))
            {
            $groupObj = $em->getRepository('TatweerTrainingBundle:Groups')->find($params['group']);
            $trainingNeed->setEmployeeGroup($groupObj);
            }
            $trainingNeed->setRequestedForEmployee($CreatedByObj);
            $trainingNeed->setCreatedBy($CreatedByObj);
            $em->persist($trainingNeed);
            $em->flush();
            
            
            // to fix “Call to a member function format() on a non-object” error 
            $entity->setStartDate($entity->getStartDate());
            $entity->setEndDate($entity->getEndDate());
            
            if(isset($params['languageOther']))
            {
            $entity->setLanguageOther($params['languageOther']);
            //$entity->setLanguage(NULL);
            }
            $entity->setSelfRequestTrainingNeedsId($trainingNeed);
            $entity->setCreatedBy($CreatedByObj);
            $em->persist($entity);
            $em->flush();
 
           if(isset($params['other']))
           {
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
    }

   
    /**
     * Creates a form to create an Individual Trainings entity.
     *
     * @param Trainings $entity The entity
     * 
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateIndividualForm(Trainings $entity)
    {
        $request           = $this->getRequest();
        $em                = $this->getDoctrine()->getManager();
        $trainingNeed      = new TrainingNeeds();
        

        $translator = $this->get('translator');
        $form = $this->createForm(new IndividualTrainingsType($translator,$this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('individualrequest_create'),
            'method' => 'POST',
            'locale'  => $request->getLocale(),
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }
    
     /**
     * Lists all IndividualTrainings entities.
     *
     * @Route("/{id}", name="selftrainings_show")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $canManage = $allowedActions = $isTrainierHr = $trainingSpecialistList = $nonManagableCostItems = $managableCostItems = $insertedManagableCostItems = $costForm = $departmentBudgetData = $totalSelectedCost = false;
        $session   = $this->getRequest()->getSession();
       // in another controller for another request
        $CurrentLoggedInUsername = $session->get('username');
        $CurrentLoggedInUserId   = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        
      
        $entity           = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserIndividualTrainingById($id);
        $trainingExpenses = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingExpenses($id);
  
        $trainingNeeds    = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($entity['selfRequestTrainingNeedsId']);  
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
        }
        
        $currentActionLog                   = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getCurrentActionLogData($entity['selfRequestTrainingNeedsId']);
        if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,7,8,9) )  && ( $currentActionLog[0]['assignedToRole'] ||  $currentActionLog[0]['assignedToTrainingSpecialist']  ) ) // is Training Department Responsible or Training manager  , HR Manager
        {
            
            if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) ) && $currentActionLog[0]['assignedToRole'] == 6 )
            $canManage = true;  // he can update the training cost
            
            if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(9) ) && $currentActionLog[0]['assignedToRole'] == 9 )
            {
                    /// get department budget
                $actorGroupId = $em->getRepository('TatweerTrainingBundle:Trainings')->getActorGroup($entity['selfRequestTrainingNeedsId']);
                    if($departmetId = $em->getRepository('TatweerTrainingBundle:Departments')->getDepartmentOfGroup($actorGroupId))
                    { 
                        $departmentBudgetData = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->getDepartmentBudget($departmetId );
                        $totalSelectedCost  = $em->getRepository('TatweerTrainingBundle:Trainings')->getTotalCost($id);
                       
                    }
            }        
            
            $isTrainierHr = true; 
            $nonManagableCostItems   = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->getNonManagableCostItems($id);
            $managableCostItems      = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->findBy(array('manageable' => 1 , 'active' => 1));
            $insertedManagableCostItems      = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->getManagableCostItems($id);
            $trainingEntity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);
            $costForm = $this->createEditForm($trainingEntity);
            $costForm = $costForm->createView();
        }
        
        
        $userEntity                      = $em->getRepository('TatweerTrainingBundle:Users')->find($entity['idUser']);
        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $userEntity->getUsername())); // get user data from ACTIVE DIRECTORY 
        $userDataFromAD->employeeGrade   = $userEntity->getEmployeeGrade();
        
        if($trainingNeeds)
        {
        if($isTrainierHr)
        {
        if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeTrainerHrAction($trainingNeeds->getIdNeed() , $trainingNeeds->getRequestedForEmployee()->getIdUser() , $trainingNeeds->getEmployeeGroup()->getIdGroup() ) )
           if($allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($trainingNeeds->getRequestedForEmployee()->getIdUser() , $trainingNeeds->getEmployeeGroup()->getIdGroup() , $trainingNeeds->getIdNeed() , true , true ))
                     // can assign to 
             if(in_array( 5, $allowedActions))
             {
             $trainingSpecialist              = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(7));
             $count=0;
             foreach ($trainingSpecialist as $k => $v)
             {
                     $trainingSpecialistList[$count]            = $this->get('ad.serivce')->getUserResults(array('username' => $v['username']));
                     $trainingSpecialistList[$count]->idUser  = $v['idUser'];
                     $count++;
             }
             }
        
        
       
        }
            
        elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeAction($trainingNeeds->getIdNeed() , $trainingNeeds->getRequestedForEmployee()->getIdUser() , $trainingNeeds->getEmployeeGroup()->getIdGroup() , true) )
        $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($trainingNeeds->getRequestedForEmployee()->getIdUser() , $trainingNeeds->getEmployeeGroup()->getIdGroup() , $trainingNeeds->getIdNeed() , false , true );
   
        $userActionLogHistory = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getUserActionLogHistory($entity['selfRequestTrainingNeedsId'] , $trainingNeeds->getEmployeeGroup()->getIdGroup() );
        }

        return array(
            'entity'           => $entity,
            'trainingExpenses' => $trainingExpenses ,
            'canManage'        => $canManage,
            'isTrainierHr'     => $isTrainierHr,
            'userentity'       => $userDataFromAD,
            'allowedActions'   => $allowedActions,
            'trainingneed_id'  => $trainingNeeds->getIdNeed(),
            'actionlog_history'=> $userActionLogHistory,
            'trainingSpecialistList'   => $trainingSpecialistList,
            'nonManagableCostItems' => $nonManagableCostItems,
            'managableCostItems'    => $managableCostItems,
            'insertedManagableCostItems' =>$insertedManagableCostItems,
            'departmentBudgetData'     => $departmentBudgetData,
            'totalSelectedCost'        => $totalSelectedCost,
            'form' => $costForm
           
           
        );
    }
    
     /**
     * Lists all IndividualTrainings entities.
     *
     * @Route("/updateactionlog/{id}", name="selftrainings_update_actionlog")
     * @Method("POST")
     */
    public function updateTrainingActionLogAction($id)
    {
        $em                    = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
     
 //$params['trainingneed_id']
        $entity           = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);
        $trainingNeeds    = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($entity->getSelfRequestTrainingNeedsId());  
        
        if(isset($params['selected_budget']) && isset($params['approve']))
            {
                // get selected program total costs
                $totalSelectedCost  = $em->getRepository('TatweerTrainingBundle:Trainings')->getTotalCost($id);
                // update department budget 
                $departmentBudget = new DepartmentBudgets();
                $departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($params['selected_budget']);
                $remainingValues  =  $departmentBudget->getRemainingValue();
                $remainingValues -= $totalSelectedCost;
                $departmentBudget->setRemainingValue($remainingValues);
                $em->flush(); 

            }
     
       
        $groupid     = $trainingNeeds->getEmployeeGroup()->getIdGroup();

        $userid      = $trainingNeeds->getRequestedForEmployee()->getIdUser();
        $groupentity  =  $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
        $userentity =  $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
        $this->get('training_action.service')->updateActionLog( $userid ,  $groupid , $params , $CurrentLoggedInUserId ,$userentity , $groupentity );
        
               // CHECK THIS GHAIDAA 
            if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($entity->getSelfRequestTrainingNeedsId()) == 2 ) // training hr team
               return $this->redirect($this->generateUrl('_followupindividualtrainingrequests'));
               elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($entity->getSelfRequestTrainingNeedsId()) == 1 ) // department responsible team
               return $this->redirect($this->generateUrl('_individualtrainingrequests'));
               else
               return $this->redirect($this->generateUrl('_requestindividualtraining'));
       
    }
    /**
     * Displays a form to edit an existing Trainings entity.
     *
     * @Route("/{id}/edit", name="selftrainings_edit")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Trainings/IndividualTraining:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        
        $session = $this->getRequest()->getSession();
        $CurrentLoggedInUsername = $session->get('username');
        $userEntity                      = $em->getRepository('TatweerTrainingBundle:Users')->findByUsername($CurrentLoggedInUsername);
        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $CurrentLoggedInUsername)); // get user data from ACTIVE DIRECTORY 
        $userDataFromAD->employeeGrade   = $userEntity[0]->getEmployeeGrade();
        
        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'userentity' => $userDataFromAD,
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
        
     //   $trainingNeedValues= $em->getRepository('TatweerTrainingBundle:TrainingNeedsValues')->find($entity->getTrainingNeedsProgram());
     //   $trainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingNeedValues->getTrainingNeed());
        
        $translator = $this->get('translator');
        $form = $this->createForm(new IndividualTrainingsType($translator,$this->getDoctrine()->getManager(),$entity->getIdTraining()), $entity, array(
            'action' => $this->generateUrl('selftrainings_update', array('id' => $entity->getIdTraining())),
            'method' => 'PUT',
            'locale'  => $request->getLocale(),
//            'trainingNeedId'  => $trainingNeed->getIdNeed(),
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }
    /**
     * Edits an existing Trainings entity.
     *
     * @Route("/{id}", name="selftrainings_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Trainings:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();
        $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trainings entity.');
        }

        
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $ModifiedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        
        if ($editForm->isValid()) {
            $this->saveData($params , $entity , $ModifiedByObj);
            $em->flush();
            
//            $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($trainingneed_id)

            return $this->redirect($this->generateUrl('selftrainings_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
       
        );
    }

    /**
     * Deletes a Trainings entity.
     *
     * @Route("/delete/{id}", name="selftrainings_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
 
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:Trainings')->find($id);
            $entityExpensesClasses = $em->getRepository('TatweerTrainingBundle:TrainingExpenses')->findByTraining($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trainings entity.');
            }
            foreach ($entityExpensesClasses as $k => $v)
            {
            $em->remove($v);
            $em->flush();
            }
            
            
            $em->remove($entity);
            $em->flush();


        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error
        }
        
        return $this->redirect($this->generateUrl('_requestindividualtraining'));
    }
    
    private function saveData($params , Trainings $entity , $ModifiedByObj)
    {
            $em = $this->getDoctrine()->getManager();
            $entity->setModifiedBy($ModifiedByObj);
            $em->persist($entity);
            $em->flush();
 
           
           foreach ($params['other'] as $k => $v)
           {
            if($v && $params['other_values'][$k])
               {
            $trainingExpense = new TrainingExpenses();
            $expenseClass    = new TrainingExpensesClasses();
            
            $expenseClass = $em->getRepository('TatweerTrainingBundle:TrainingExpensesClasses')->find($v);
            
            if($trainingExpense = $em->getRepository('TatweerTrainingBundle:TrainingExpenses')->findBy(array('expenseClass' => $v , 'training' =>$entity->getIdTraining()  )))
            {
            $trainingExpense[0]->setExpenseClass($expenseClass);
            $trainingExpense[0]->setTraining($entity);
            $trainingExpense[0]->setValue($params['other_values'][$k]);
            }
            else
            {
            
            $trainingExpense = new TrainingExpenses();
            //echo $entity->getCountry();
            // set training Expenses
            $trainingExpense->setExpenseClass($expenseClass);
            $trainingExpense->setTraining($entity);
            $trainingExpense->setValue($params['other_values'][$k]);
            $em->persist($trainingExpense);
            }
            $em->flush();
               }
           }
    }
}
