<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TaskschedulerController extends Controller
{
    /**
     * send Reminder
     *
     * @Route("/sendreminder", name="sendreminder")
     */
    public function sendReminderAction()
    {
        $date  = new \DateTime();
        $today = $date->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        // Evaluation Period Reminder
        if($evaluation      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->findBy( array( 'reminderDate' =>  $today , 'active' => 1) ))
        {
            foreach($evaluation as $k => $v) 
            {
                // get all departments and groups moderators for each period 
                if($userLists = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(2,3) ))
                // send reminder 
                        foreach ($userLists as $mk => $mv)
                        {
                              $this->sendEmail( $mv['username'] ,  'reminder_evaluation_period' , $this->get('translator')->trans('Employees evaluation reminder', array(), 'mail'));

                        }
            }
                //    echo $v->getIdPeriod();
        }
        //-------------------------------------------------
       // Training need Reminder 
        if($trainingNeed      = $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->findBy( array( 'trainingNeedsReminderDate' =>  $today , 'trainingNeedsActive' => 1) ))
        {
            foreach($trainingNeed as $k => $v) 
            {
                // get all departments and groups moderators for each period 
                if($userLists = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(2,3) ))
                // send reminder 
                        foreach ($userLists as $mk => $mv)
                        {
                          
                               $this->sendEmail( $mv['username'] ,  'reminder_training_needs_period' , $this->get('translator')->trans('Employees training needs reminder', array(), 'mail'));

                        }
            }
                //    echo $v->getIdPeriod();
        }
        //--------------------------------------------------
        // Training Reminder 
        if ($preferences = $em->getRepository('TatweerTrainingBundle:Preferences')->find(1))
         $evaluationDuration = $preferences->getEvaluationDuration();

         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t")
          ->where("t.approvedByHr = 1 AND t.chosenByEmployee = 1 AND DATE_ADD(t.endDate, $evaluationDuration, 'MONTH') = :today " )
          ->setParameter( 'today' , $today )
          ->getQuery();
        
        if($training = $query->getArrayResult())
        {

            foreach($training as $k => $v) 
            {
                // get training need 
                if($trainingNeed = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingNeedByTraining($v['idTraining']))
                {
                        if($userLists = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($trainingNeed->getEmployeeGroup()->getIdGroup() ,  array(2,3) ))
                        {
                      // send reminder 
                           foreach ($userLists as $mk => $mv)
                           {

                              
                               $this->sendEmail( $mv['username'] ,  'reminder_employees_training_evaluation_date' , $this->get('translator')->trans('Employees training evaluation reminder', array(), 'mail'));

                           }
                        }
                }
            }
        }
        
        
       
        
         return $this->render('TatweerTrainingBundle:Default:index.html.twig');
    }
    
    
    
    private function sendEmail( $tousername ,  $template , $subject )
    {
       $request           = $this->getRequest();
        $userDataFromAD = $this->get('ad.serivce')->getUserResults(array('username' => $tousername));
        
        $fullname = ($request->getLocale() == 'ar' ? $userDataFromAD->FullArabicName : $userDataFromAD->DisplayName);

    //$userDataFromAD->Email
        $this->get('mail.serivce')->sendEmail('delivery@t4edu.com', $userDataFromAD->Email ,             
            $this->renderView(
                'TatweerTrainingBundle:MailTemplates:'.$template.'.html.twig',
                array('name' => $fullname ) 
            )
            , $subject
            );
        
       
    }
}
