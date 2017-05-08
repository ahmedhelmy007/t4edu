<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Tatweer\TrainingBundle\Entity\Users;
use Tatweer\TrainingBundle\Entity\TrainingNeeds;
use Tatweer\TrainingBundle\Entity\TrainingNeedsValues;
use Tatweer\TrainingBundle\Entity\TrainingNeedsActionsLog;
use Tatweer\TrainingBundle\Entity\Groups;
use Tatweer\TrainingBundle\Entity\Trainings;
use Tatweer\TrainingBundle\Entity\DepartmentBudgets;
/**
 * Evaluation controller.
 *
 * @Route("/trainingneeds")
 */
class TrainingneedsController extends Controller
{
    
   /**
     * Review Training Needs – View Request Details for Employee 
     *
     * @Route("/requests", name="_trainingneedsrequests")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneedsrequests.html.twig")
     */
    public function trainingneedrequestsAction(Request $request)
    {

        $em                    = $this->getDoctrine()->getManager();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $TrainingNeedsRequests = false;
        // get current active period 
        if($currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
       
        $TrainingNeedsRequests = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getUserTrainingNeedsRequests($CurrentLoggedInUserId , $trainingNeedPeriodId );
 
        }
        return array(
            'data_result'               => $TrainingNeedsRequests,
            'pageSubTitle' => $this->get('translator')->trans('My training needs' , array() , 'navbar')
        );
        
    }
    
    
   /**
     * Review Training Needs – View Request Details for Employee 
     *
     * @Route("/requestdetails", name="_trainingneedsdetails")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneedsrequests.html.twig")
     */
    public function trainingNeedRequestDetailsAction(Request $request)
    {
       

        $em                    = $this->getDoctrine()->getManager();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $TrainingNeedsRequests = $hasTrainingDetails = false;
        
      if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
           else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }

       if($trainingNeedPeriodId)
        if($TrainingNeedsRequests = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getUserTrainingNeedsRequestsWithDetailes($CurrentLoggedInUserId , $trainingNeedPeriodId ))
        {
         foreach ($TrainingNeedsRequests as $k => $v)
        {
            if($em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($v['idNeed']))
            {
            $hasTrainingDetails = true;
            }
            
        } 
        }
        
       /**/  
 
        return array(
            'data_result'               => $TrainingNeedsRequests,
            'hasTrainingDetails'        => $hasTrainingDetails,
            'isTrainingDetailspage'     => true,
            'pageSubTitle' => $this->get('translator')->trans('My Training details' , array() , 'navbar')
        );
        
    }
    
       /**
     * show training need Request history , User data 
     *
     * @Route("/{groupid}/{userid}/show/actions", name="_showtrainingneedsactions")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneedactions.html.twig")
     */
    public function showTrainingneedActionsAction(Request $request, $groupid , $userid)
    {
   
        return $this->trainingneedactionsAction($request, $groupid , $userid , true);     
    }
   /**
     * show training need Request history , User data , Comment and request actions 
     *
     * @Route("/{groupid}/{userid}/trainingneeds/actions", name="_trainingneedsactions")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneedactions.html.twig")
     */
    public function trainingneedactionsAction(Request $request, $groupid , $userid , $viewMode = false )
    {

 
       
        
        $userDataFromAD        = $trainingneedID = $allowedActions = $userActionLogHistory = $trainingSpecialistList =  false;
        $userentity            = new Users();
        $trainingneedObj       = new TrainingNeeds();
        $em                    = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();

       $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
       $userentity            = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
       $groupentity           = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);

      if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
           else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
     
 

         $findByConditions = array('requestedForEmployee' => $userid , 'trainingneedPeriod' =>$trainingNeedPeriodId , 'employeeGroup' => $groupid );
        if($trainingneedObj = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->findBy($findByConditions))
        { 
        $trainingneedID            =  $trainingneedObj[0]->getIdNeed();
        
        }
        $userActionLogHistory = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getUserActionLogHistory($trainingneedID , $groupid );
      
        // foreach ($userActionLogHistory as $k => $v)
       // {
           // $userActionLogHistory[$k]['user'] =  $this->get('ad.serivce')->getUserResults(array('username' => $v['username']));
           // if($v['trainingSpecialistUsername'])
           // $userActionLogHistory[$k]['training_specialist'] =  $this->get('ad.serivce')->getUserResults(array('username' => $v['trainingSpecialistUsername']));
          //  if($v['requestedForEmployee'])
           // $userActionLogHistory[$k]['requested_for_employee'] =  $this->get('ad.serivce')->getUserResults(array('username' => $v['requestedForEmployeeUsername']));
            
       // }

 

        if(isset($params['trainingneed_id']))
        {

               $this->get('training_action.service')->updateActionLog( $userid ,  $groupid , $params , $CurrentLoggedInUserId ,$userentity , $groupentity );
               $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
               //return $this->redirect($this->generateUrl('_followuprequestbytrainterandhr'));
               
               // CHECK THIS GHAIDAA 
               if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($params['trainingneed_id']) == 2 ) // training hr team
               return $this->redirect($this->generateUrl('_followuprequestbytrainterandhr'));
               elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($params['trainingneed_id']) == 1 ) // department responsible team
               return $this->redirect($this->generateUrl('_followuptrainingneedsuserlist'));
               else
               return $this->redirect($this->generateUrl('_trainingneedsactions', array('groupid' => $groupid  , 'userid' =>  $userid)));
               
               //return $this->redirect($this->generateUrl('_trainingneedsactions', array('groupid' => $groupid  , 'userid' =>  $userid)));
        }
       
        if(!$viewMode)
        {
                
            if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeAction($trainingneedID , $userid , $groupid) )
             $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($userid ,  $groupid , $trainingneedID);
            elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeTrainerHrAction($trainingneedID , $userid , $groupid) )
             $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($userid ,  $groupid , $trainingneedID , true);

             // can assign to 
            if($allowedActions)
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
       
        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $userentity->getUsername())); // get user data from ACTIVE DIRECTORY 
                
        return array(
            'userentity'               => $userDataFromAD,
            'trainingneed_id'          => $trainingneedID,
            'actionlog_history'        => $userActionLogHistory,
            'allowedActions'           => $allowedActions,
            'trainingSpecialistList'   => $trainingSpecialistList,
        );
    }
    /**
     * Creates a form to evaluate a User.
     *
     * @return form
     */
    private function createEvaluationForm( $evaluationID = null)
    {
        $em          = $this->getDoctrine()->getManager();
        return $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->buildForm($evaluationID);
    }
    
    
   /**
     * request training need for User
     *
     * @Route("/{groupid}/{userid}/request", name="_requesttrainingneed")
     * 
     * @Template("TatweerTrainingBundle:Forms:requesttrainingneed.html.twig")
     */
    public function requestAction(Request $request, $groupid , $userid)
    {
        $form = $userDataFromAD = $currentActivePeriod  = $lastActivePeriod = $form_values = $canSuggestTrainings = $hasHRPermissions = false;
        $isEvaluated = $canUpdate = true;
        $evaluationID = null;
        $trainingNeedSections = array ('objectives'=> 'objectives' 
            , 'appraisaltrainings'=>'appraisal trainings'
            , 'additionaltrainings' => 'additional trainings'
            , 'suggestedbyhr' =>'suggested trainings by HR');
        
        $em          = $this->getDoctrine()->getManager();
        $entity      = new Users();
        $params      = $this->getRequest()->request->all();
 

        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();

   
        if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
        else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
        

        

        $findByConditions = array( 'requestedForEmployee' => $userid , 'trainingneedPeriod' =>$trainingNeedPeriodId , 'employeeGroup' => $groupid );
        if($evaluation = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->findBy($findByConditions))
        {
        $evaluationID =  $evaluation[0]->getIdNeed();
        }
        
        $actionLog_data = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getCurrentActionLogData($evaluationID);
        if( ( isset($actionLog_data[0]) && $actionLog_data[0]['assignedToRole'] ) && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,8)) )
        {
            $hasHRPermissions      =  true;
            
            $canSuggestTrainings = $em->getRepository('TatweerTrainingBundle:TrainingNeedsValues')->findBy(array('trainingNeed' => $evaluationID , 'section' => 'suggested trainings by HR'));
         if(isset($canSuggestTrainings[0])) $canSuggestTrainings = true; else $canSuggestTrainings = false;
            
        }

        
        
        if(!$currentEvaluationActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenEvaluationPeriod())
        {
            $lastActiveEvaluationPeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastEvaluationPeriod();
            $evaluationPeriodId              = $lastActiveEvaluationPeriod[0]['idPeriod'];
        }
        else
        {
            $evaluationPeriodId    = $currentEvaluationActivePeriod[0]['idPeriod'];
        }
        
        if(!$em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->findBy(array( 'employee' => $userid , 'evaluationPeriod' =>$evaluationPeriodId , 'group' => $groupid )))
                $isEvaluated = false; 
        
        // if form is submitted for saving or updating evaluation form 
        if(isset($_POST['save_evaluation']))
        {
          if(isset($_POST['evaluation_id']))
          {
            $TrainingNeed    = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($_POST['evaluation_id']);
          }
          else 
          {
            $TrainingNeed    = new TrainingNeeds();
          }
          
            $CreatedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
            $EmployeeObj           = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $PeriodObj             = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($_POST['period_id']);
            $GroupObj              = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
            
            // save employee evaluation 
               
               $TrainingNeed->setRequestedForEmployee($EmployeeObj);
               $TrainingNeed->setTrainingneedPeriod($PeriodObj);
               $TrainingNeed->setEmployeeGroup($GroupObj);

               if(isset($_POST['evaluation_id']))
               {
                    // if update evaluation
               $TrainingNeed->setModifiedBy($CreatedByObj);
               }
               else 
               {
                    // if insert new evaluation
               $TrainingNeed->setCreatedBy($CreatedByObj);
               $em->persist($TrainingNeed);
               }
               
               $em->flush(); 

       
            // save evaluation values   
            foreach($params['e_values'] as $section => $v )
            { 


                foreach( $v as $levelKey => $levelValue )
                {
                $TrainingNeedValue = false;
                    	$optionObj = $em->getRepository('TatweerTrainingBundle:TrainingNeedsOptions')->find($levelValue);
                        $valueAr = $params[$section]['ar'][$levelKey];
                        $valueEn = $params[$section]['en'][$levelKey];
                        if(isset($params['inserted_values'][$section][$levelKey]))
                         { 
                          $TrainingNeedValue = $em->getRepository('TatweerTrainingBundle:TrainingNeedsValues')->find($params['inserted_values'][$section][$levelKey]);
                         }
                         

                
               if(!($TrainingNeedValue))
                { 
                   // if insert new evaluation values
               $TrainingNeedValue = new TrainingNeedsValues(); 
                }
               
               $TrainingNeedValue->setSection($trainingNeedSections[$section]);
               
               $TrainingNeedValue->setValueAr($valueAr);
               $TrainingNeedValue->setValueEn($valueEn);
               $TrainingNeedValue->setSelectedOption($optionObj);
               $TrainingNeedValue->setTrainingNeed($TrainingNeed);
               $TrainingNeedValue->setCreatedBy($CreatedByObj);
               
               if(!isset($params['inserted_values'][$section][$levelKey]))
               $em->persist($TrainingNeedValue);
               
               $em->flush(); 
                }
            }
            
               $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
               
               return $this->redirect($this->generateUrl('_requesttrainingneed', array('groupid' => $groupid  , 'userid' =>  $userid)));
        }
        
        if($isEvaluated)
        {
            $entity                          = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $entity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $entity->getEmployeeGrade();
            $userDataFromAD->idUser          = $userid;
            
            $form                            = $this->createEvaluationForm($evaluationID);
            
            if(isset($form['valuesResult']))
                $form_values = $form['valuesResult'];
            
            if($evaluationID)
            {
             if(!$canUpdate = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeAction($evaluationID , $userid , $groupid))
             {
              $canUpdate = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeTrainerHrAction($evaluationID , $userid , $groupid);
             }
            }
        }    
        return array(
            'userentity'               => $userDataFromAD,
           // 'form_sections'            => $form['sectionResult'],
           // 'form_criterias'           => $form['criteriasResult'],
            'form_options'             => $form['optionsResult'],
            'form_values'              => $form_values,
            'currentEvaluationId'      => $evaluationID ,
            'currentActivePeriod'      => $currentActivePeriod ,
            'lastActivePeriod'         => $lastActivePeriod ,
            'groupid'                  => $groupid,
            'hasHRPermissions'         => $hasHRPermissions ,
            'isEvaluated'              => $isEvaluated , 
            'canUpdate'                => $canUpdate,
            'canSuggestTrainings'      => $canSuggestTrainings,
            'pageSubTitle' => $this->get('translator')->trans('TRAINING NEEDS ASSESSMENTS FORM' , array() , 'trainingneed')
            
          
      
        );
    }
    
    
    
  
   /**
     * show user training need
     *
     * @Route("/{groupid}/{userid}/show", name="_showtrainingneed")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:show.html.twig")
     */
    public function showAction(Request $request, $groupid , $userid)
    {
        return $this->requestAction($request, $groupid , $userid);
    }
    
    
     /**
     * export to pdf 
     *
     * @Route("/{groupid}/{userid}/export", name="_exporttrainingneed")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds:show.html.twig")
     */
    public function export(Request $request, $groupid , $userid)
    {
        $form = $userDataFromAD = $currentActivePeriod  = $lastActivePeriod = $form_values = false;
        $evaluationID = null;
        
        $em          = $this->getDoctrine()->getManager();
        $entity      = new Users();
   
 

        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();

        
        if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
        else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
        
        
       // if($CurrentLoggedInUserId == $userid )
        $findByConditions = array( 'requestedForEmployee' => $userid , 'trainingneedPeriod' =>$trainingNeedPeriodId , 'employeeGroup' => $groupid );
       // else 
       // $findByConditions = array('createdBy' => $CurrentLoggedInUserId , 'requestedForEmployee' => $userid , 'trainingneedPeriod' =>$trainingNeedPeriodId , 'employeeGroup' => $groupid );

        
        
        
        if($evaluation = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->findBy($findByConditions))
        {
        $evaluationID =  $evaluation[0]->getIdNeed();
        }
            $entity                          = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $entity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $entity->getEmployeeGrade();
            $userDataFromAD->idUser          = $userid;
            
            $form                            = $this->createEvaluationForm($evaluationID);
            
            if(isset($form['valuesResult']))
                $form_values = $form['valuesResult'];
          
      
        $mpdf = new \mPDF('ar', 'A4',0,'',15,15,20,20,5,5,'L');
        $mpdf->useOnlyCoreFonts = true;
        $path = $this->get('kernel')->getRootDir() . '/../src/Tatweer/TrainingBundle/Resources/public/css/print.css';
        $stylesheet = file_get_contents($path); // external css
        $mpdf->WriteHTML($stylesheet,1);
        
        $html = $this->renderView('TatweerTrainingBundle:TrainingNeeds:show.html.twig' ,  
        array(
            'userentity'               => $userDataFromAD,
            'form_options'             => $form['optionsResult'],
            'form_values'              => $form_values,
            'currentEvaluationId'      => $evaluationID ,
            'currentActivePeriod'      => $currentActivePeriod ,
            'lastActivePeriod'         => $lastActivePeriod , 
 
            'export_pdf'               => true
        )
                );

        $mpdf->WriteHTML($html, 2);
        $mpdf->Output($entity->getEnglishFullname().'.pdf','I');
        
    }

   /**
     * request training need for User
     *
     * @Route("/{groupid}/{userid}/user/trainingdetails", name="_usertrainingdetails")
     * 
     * @Template("TatweerTrainingBundle:TrainingNeeds/TrainingDetails:trainingneed_details.html.twig")
     */
    public function userTrainigDetailsAction(Request $request, $groupid , $userid)
    {
         $em                    = $this->getDoctrine()->getManager();
         $allowedActions        = $selectedTrainingProgram = $canManage = $isEmployee = $departmentBudgetData = $totalSelectedCost = false;
         $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
         $userentity            = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
         $groupentity           = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
         $params                = $this->getRequest()->request->all();

         
      if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastTrainingNeedsPeriod();
            $trainingNeedPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
           else
        {
            $trainingNeedPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
     
 

        $findByConditions = array('requestedForEmployee' => $userid , 'trainingneedPeriod' =>$trainingNeedPeriodId , 'employeeGroup' => $groupid );
        if($trainingneedObj = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->findBy($findByConditions))
        { 
        $trainingneedID            =  $trainingneedObj[0]->getIdNeed();
        
        }
         
         
         $userentity            = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
         $userDataFromAD        = $this->get('ad.serivce')->getUserResults(array('username' => $userentity->getUsername())); // get user data from ACTIVE DIRECTORY 
         $trainingData = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserTraining($groupid , $userid);
         
         if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeAction($trainingneedID , $userid , $groupid) )
         $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($userid ,  $groupid , $trainingneedID);
            elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeTrainerHrAction($trainingneedID , $userid , $groupid) )
             $allowedActions                  = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->allowedActions($userid ,  $groupid , $trainingneedID , true);

        if(isset($params['trainingneed_id']))
        {
            if(isset($params['selected_program']))
            {
                // update training details with the selected program
                $selectedTraining = new Trainings();
                $selectedTraining = $em->getRepository('TatweerTrainingBundle:Trainings')->find($params['selected_program']);
                $selectedTraining->setChosenByEmployee(1); // 
                $em->flush(); 
            }
            
            if(isset($params['selected_budget']) && isset($params['approve']))
            {
                // get selected program total costs
                $trainingId  = $em->getRepository('TatweerTrainingBundle:Trainings')->getSelectedTraining($groupid , $userid);
                $totalSelectedCost  = $em->getRepository('TatweerTrainingBundle:Trainings')->getTotalCost($trainingId);
                // update department budget 
                $departmentBudget = new DepartmentBudgets();
                $departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($params['selected_budget']);
                $remainingValues  =  $departmentBudget->getRemainingValue();
                $remainingValues -= $totalSelectedCost;
                $departmentBudget->setRemainingValue($remainingValues);
                $em->flush(); 

                 
            }
               $this->get('training_action.service')->updateActionLog( $userid ,  $groupid , $params , $CurrentLoggedInUserId ,$userentity , $groupentity );
               $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
              // CHECK THIS GHAIDAA 
               if( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($params['trainingneed_id']) == 2 ) // training hr team
               return $this->redirect($this->generateUrl('_trainer_hr_trainingdetails'));
               elseif( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->assignedActorType($params['trainingneed_id']) == 1 ) // department responsible team
               return $this->redirect($this->generateUrl('_trainingdetails'));
               else
               return $this->redirect($this->generateUrl('_usertrainingdetails', array('groupid' => $groupid  , 'userid' =>  $userid)));
               
  
        }         
        
        $selectedTrainingProgram =  $em->getRepository('TatweerTrainingBundle:Trainings')->getSelectedTraining($groupid , $userid);
           
        if($CurrentLoggedInUserId == $userid )
        {
            if(!$selectedTrainingProgram ) 
                  $selectedTrainingProgram =  'canSelect';
            
                  $isEmployee = true;
            
        }
                
            if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,8,9) )) // is Training Department Responsible or Training manager  , HR Manager
            {
                $canManage = true; // he can update the training need request to add SUGGESTED TRAINING PROGRAMS (From HR)
                $currentActionLog      =  $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getCurrentActionLogData($trainingneedID);

                if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(9) )  && ($currentActionLog[0]['assignedToRole'] == 9) )
                {
       
                    /// get department budget
                    if($departmetId = $em->getRepository('TatweerTrainingBundle:Departments')->getDepartmentOfGroup($groupid))
                    { 
                        $departmentBudgetData = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->getDepartmentBudget($departmetId );
                        // get selected program 
                        $trainingId  = $em->getRepository('TatweerTrainingBundle:Trainings')->getSelectedTraining($groupid , $userid);
                        $totalSelectedCost  = $em->getRepository('TatweerTrainingBundle:Trainings')->getTotalCost($trainingId);
                       
                    }
                }
            }
        $userActionLogHistory = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getUserActionLogHistory($trainingneedID , $groupid );
        
        return array(
            'userentity'               => $userDataFromAD,
            'data_result'              => $trainingData,
            'trainingneed_id'          => $trainingneedID,
            'allowedActions'           => $allowedActions,
            'groupid'                  => $groupid,
            'userid'                   => $userid,
            'selectedTrainingProgram'  => $selectedTrainingProgram,
            'isEmployee'               => $isEmployee,
            'canManage'                => $canManage,
            'departmentBudgetData'     => $departmentBudgetData,
            'totalSelectedCost'        => $totalSelectedCost,
            'actionlog_history'        => $userActionLogHistory
        );
         
    }
    
 
}
