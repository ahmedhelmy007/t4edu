<?php

namespace Tatweer\TrainingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class SendReminderCommand extends ContainerAwareCommand 
{
    protected function configure()
    {
        parent::configure();
        $this->setName('training:sendreminder')->setDescription('Sends Reminder mails');
    }




    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $date  = new \DateTime();
        $today = $date->format('Y-m-d');

        //$em = $this->getDoctrine()->getManager();
        $em = $this->getContainer()->get('doctrine')->getManager();
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
                              $this->sendEmail( $mv['username'] ,  'reminder_evaluation_period' , $this->getContainer()->get('translator')->trans('Employees evaluation reminder', array(), 'mail'));

                        }
            }
               
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
                          
                               $this->sendEmail( $mv['username'] ,  'reminder_training_needs_period' , $this->getContainer()->get('translator')->trans('Employees training needs reminder', array(), 'mail'));

                        }
            }
                
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

                              
                               $this->sendEmail( $mv['username'] ,  'reminder_employees_training_evaluation_date' , $this->getContainer()->get('translator')->trans('Employees training evaluation reminder', array(), 'mail'));

                           }
                        }
                }
            }
        }
        
    }
    
    
    
    private function sendEmail( $tousername ,  $template , $subject )
    {
       //$request           = $this->getRequest();
        $userDataFromAD = $this->getContainer()->get('ad.serivce')->getUserResults(array('username' => $tousername));
        
        $fullname = ($this->getContainer()->get('translator')->getLocale() == 'ar' ? $userDataFromAD->FullArabicName : $userDataFromAD->DisplayName);
 
    //$userDataFromAD->Email

        $this->getApplication()->getKernel()->getContainer()->get('mail.serivce')->sendEmail('delivery@t4edu.com', $userDataFromAD->Email ,             
            $this->getContainer()->get('templating')->render(
                'TatweerTrainingBundle:MailTemplates:'.$template.'.html.twig',
                array('name' => $fullname ) 
            )
            , $subject
            );
        
       
    }
}
