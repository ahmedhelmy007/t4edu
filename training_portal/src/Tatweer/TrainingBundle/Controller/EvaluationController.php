<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Tatweer\TrainingBundle\Entity\Users;
use Tatweer\TrainingBundle\Entity\EmployeesEvaluations;
use Tatweer\TrainingBundle\Entity\EmployeesEvaluationValues;




/**
 * Evaluation controller.
 *
 * @Route("/evaluation")
 */
class EvaluationController extends Controller
{
  
    /**
     * Creates a form to evaluate a User.
     *
     * @return form
     */
    private function createEvaluationForm( $evaluationID = null)
    {
        $em          = $this->getDoctrine()->getManager();
        return $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->buildForm($evaluationID);
    }
    
    
   /**
     * Evaluate User
     *
     * @Route("/{groupid}/{userid}/evaluate", name="_evaluate")
     * 
     * @Template("TatweerTrainingBundle:Forms:evaluate.html.twig")
     */
    public function evaluateAction(Request $request, $groupid , $userid)
    {
        $form = $userDataFromAD = $currentActivePeriod  = $lastActivePeriod = $form_values = false;
        $evaluationID = null;

        $em          = $this->getDoctrine()->getManager();
        $entity = new Users();
        $evaluation  = new EmployeesEvaluations();

        if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenEvaluationPeriod())
        { 
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastEvaluationPeriod();
            $evaluationPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
        else
        {
            $evaluationPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
        $CurrentLoggedInUserId     = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        
        
        $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId(); //'createdBy' => $CurrentLoggedInUserId ,
        if($evaluation = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->findBy(array( 'employee' => $userid , 'evaluationPeriod' =>$evaluationPeriodId , 'group' => $groupid )))
        {
        $evaluationID =  $evaluation[0]->getIdEvaluation();
        
        //$form_values  =  $em->getRepository('TatweerTrainingBundle:EmployeesEvaluationValues')->findBy(array('evaluation' => $evaluationID ) );
        }
        
        // if form is submitted for saving or updating evaluation form 
        if(isset($_POST['save_evaluation']))
        {
          if(isset($_POST['evaluation_id']))
          {
            $EmployeeEvaluation    = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->find($_POST['evaluation_id']);
          }
          else 
          {
            $EmployeeEvaluation    = new EmployeesEvaluations();
          }
          
            $CreatedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
            $EmployeeObj           = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $PeriodObj             = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->find($_POST['period_id']);
            $GroupObj              = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
            
            // save employee evaluation 
               
               $EmployeeEvaluation->setEmployee($EmployeeObj);
               $EmployeeEvaluation->setEvaluationPeriod($PeriodObj);
               $EmployeeEvaluation->setGroup($GroupObj);

               if(isset($_POST['evaluation_id']))
               {
                    // if update evaluation
               $EmployeeEvaluation->setModifiedBy($CreatedByObj);
               }
               else 
               {
                    // if insert new evaluation
               $EmployeeEvaluation->setCreatedBy($CreatedByObj);
               $em->persist($EmployeeEvaluation);
               }
               
               $em->flush(); 
              
            // save evaluation values 
            foreach($_POST['e_values'] as $k => $v )
            { 
               $criteriaObj = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluationCriterias')->find($k);
               $optionObj = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluationOptions')->find($v);
               
               if(isset($_POST['evaluation_id']))
               {
                   // if update evaluation values
               $EmployeeEvaluationValue = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluationValues')->findBy( array( 'evaluation'=> $_POST['evaluation_id'] , 'criteria' => $k ));
               $value_id                = $EmployeeEvaluationValue[0]->getIdValue();
               $EmployeeEvaluationValue = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluationValues')->find($value_id);
                
               }
               else 
               {
                   // if insert new evaluation values
               $EmployeeEvaluationValue = new EmployeesEvaluationValues(); 
               }
               
               $EmployeeEvaluationValue->setCriteria($criteriaObj);
               $EmployeeEvaluationValue->setEvaluation($EmployeeEvaluation);
               $EmployeeEvaluationValue->setSelectedOption($optionObj);
               
               if(!isset($_POST['evaluation_id']))
               $em->persist($EmployeeEvaluationValue);
               
               $em->flush(); 

            }
               $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
               return $this->redirect($this->generateUrl('_evaluate', array('groupid' => $groupid  , 'userid' =>  $userid)));
        }
        
        
        
       // if($currentActivePeriod)
       // {
            
            $entity                          = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $entity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $entity->getEmployeeGrade();
            $userDataFromAD->idUser          = $userid;
            
            $form                            = $this->createEvaluationForm($evaluationID);
            $PerformancePotentialsNet        = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->getPerformancePotentialsIntersect($evaluationID);
       // }
        
        

        return array(
            'userentity'               => $userDataFromAD,
            'form_sections'            => $form['sectionResult'],
            'form_criterias'           => $form['criteriasResult'],
            'form_options'             => $form['optionsResult'],
            'currentEvaluationId'      => $evaluationID ,
            'currentActivePeriod'      => $currentActivePeriod ,
            'lastActivePeriod'         => $lastActivePeriod ,
            'groupid'                  => $groupid,
            'performancePotentialsNet' => $PerformancePotentialsNet,
            'pageSubTitle' => $this->get('translator')->trans('Performance and Potentials Measurement Form' , array() , 'evaluation')
            
            
          
      
        );
    }
   /**
     * show user Evaluation
     *
     * @Route("/{groupid}/{userid}/show", name="_showevaluation")
     * 
     * @Template("TatweerTrainingBundle:EmployeesEvaluations:show.html.twig")
     */
    public function showAction(Request $request, $groupid , $userid)
    {
        return $this->evaluateAction($request, $groupid, $userid);
    }
     /**
     * export to pdf 
     *
     * @Route("/{groupid}/{userid}/export", name="_export")
     * 
     * @Template("TatweerTrainingBundle:Forms:evaluate.html.twig")
     */
    public function export(Request $request, $groupid , $userid)
    {

        $evaluationID = null;
        $em          = $this->getDoctrine()->getManager();
        $currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenEvaluationPeriod();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        if(!$currentActivePeriod   = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenEvaluationPeriod())
        {
            $lastActivePeriod      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->getLastEvaluationPeriod();
            $evaluationPeriodId    = $lastActivePeriod[0]['idPeriod'];
        }
        else
        {
            $evaluationPeriodId    = $currentActivePeriod[0]['idPeriod'];
        }
        
        
        if($evaluation = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->findBy(array( 'employee' => $userid , 'evaluationPeriod' =>$evaluationPeriodId , 'group' => $groupid )))
        {
        $evaluationID =  $evaluation[0]->getIdEvaluation();
        }
       // if($currentActivePeriod)
       // {
            
            $entity                          = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $entity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $entity->getEmployeeGrade();
            $userDataFromAD->idUser          = $userid;

            
            $form                            = $this->createEvaluationForm($evaluationID);
            $PerformancePotentialsNet        = $em->getRepository('TatweerTrainingBundle:EmployeesEvaluations')->getPerformancePotentialsIntersect($evaluationID);
 
       // }
      
        $mpdf = new \mPDF('ar', 'A4',0,'',15,15,20,20,5,5,'L');
        $mpdf->useOnlyCoreFonts = true;
        $path = $this->get('kernel')->getRootDir() . '/../src/Tatweer/TrainingBundle/Resources/public/css/print.css';
        $stylesheet = file_get_contents($path); // external css
        $mpdf->WriteHTML($stylesheet,1);
        
        $html = $this->renderView('TatweerTrainingBundle:Forms:evaluate.html.twig' ,  
        array(
            'userentity'               => $userDataFromAD,
            'form_sections'            => $form['sectionResult'],
            'form_criterias'           => $form['criteriasResult'],
            'form_options'             => $form['optionsResult'],
            'currentActivePeriod'      => $currentActivePeriod ,
            'lastActivePeriod'         => $lastActivePeriod ,
            'performancePotentialsNet' => $PerformancePotentialsNet,
            'export_pdf'               => true
        )
                );

        $mpdf->WriteHTML($html, 2);
        $mpdf->Output($entity->getEnglishFullname().'.pdf','I');
        
    }
    
}
