<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\DependencyInjection\ContainerInterface;
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
 * @Route("/trainingaction")
 */
class TrainingActionController extends Controller
{
    protected  $entityManager;
    protected  $locale;
    protected  $mailer;
    protected  $activeDirectory;
    protected  $translator;
    protected  $templating;

    public function __construct($entityManager ,   ContainerInterface $container , $mailer , $activeDirectory ,$translator ,$templating ) {
        $this->entityManager = $entityManager;
        $this->locale = $container->get('request')->getLocale();
        $this->mailer = $mailer;
        $this->activeDirectory = $activeDirectory;
        $this->translator = $translator;
        $this->templating = $templating;
    }
    
    public function updateActionLog( $userid ,  $groupid , $params , $CurrentLoggedInUserId ,$userentity , $groupentity )
    {
       $em                                 = $this->entityManager;   
       $nonHrCanTakeCurrentAction          = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeAction($params['trainingneed_id'] , $userid , $groupid);
       $hrCanTakeCurrentAction             = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->canTakeTrainerHrAction($params['trainingneed_id'] , $userid , $groupid);
       $currentActionLog                   = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->getCurrentActionLogData($params['trainingneed_id']);

       if(isset($params['sendback']))
        {
            if ( !is_null($currentActionLog[0]['assignedToGroup']) && $nonHrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 3 ) // is moderator
            $this->moderatorSendBackRequest($params , $CurrentLoggedInUserId ,$userentity , $groupentity ); 
            elseif ( !is_null($currentActionLog[0]['assignedToGroup']) && $nonHrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 2 ) // is moderator
            $this->departmentManagerSendBackRequest($params , $CurrentLoggedInUserId ,$userentity , $groupentity ); 
            elseif( !is_null($currentActionLog[0]['assignedToTrainingSpecialist']) && $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(7) )) // is training specialist 
            $this->trainingSpecialistSendBackRequest($params , $CurrentLoggedInUserId ); 
            elseif( ($currentActionLog[0]['assignedToRole'] == 8) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(8) )) // is training manager
            $this->trainingManagerSendBackRequest($params , $CurrentLoggedInUserId  );            
            elseif( ($currentActionLog[0]['assignedToRole'] == 6) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) )) // is training responsible
            $this->trainingResponsibleSendBackRequest($params , $CurrentLoggedInUserId  , $groupentity );   
            elseif( ($currentActionLog[0]['assignedToRole'] == 9) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(9) )) // is HR manager
            $this->hrManagerSendBackRequest($params , $CurrentLoggedInUserId );  
        }
        else if(isset($params['approve']))
        {
            if ( !is_null($currentActionLog[0]['assignedToGroup']) && $nonHrCanTakeCurrentAction &&   $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 3 ) // is moderator
            $this->moderatorApproveRequest($params , $CurrentLoggedInUserId , $userentity , $groupentity );
            elseif ( !is_null($currentActionLog[0]['assignedToGroup']) && $nonHrCanTakeCurrentAction &&   $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 2 ) // is department manager 
            $this->departmentManagerApproveRequest($params , $CurrentLoggedInUserId , $userentity , $groupentity );
            elseif( ($currentActionLog[0]['assignedToRole'] == 6) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) )) // is training responsible
            $this->trainingResponsibleApproveRequest($params , $CurrentLoggedInUserId );     
            elseif( ($currentActionLog[0]['assignedToRole'] == 8) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(8) )) // is training manager
            $this->trainingManagerApproveRequest($params , $CurrentLoggedInUserId );     
            elseif( ($currentActionLog[0]['assignedToRole'] == 9) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(9) )) // is HR manager
            $this->hrManagerApproveRequest($params , $CurrentLoggedInUserId ,  $userid ,  $groupid , $userentity);     
            
        }
        else if(isset($params['reject']))
        {
            if ( !is_null($currentActionLog[0]['forwardedToUser']) && $nonHrCanTakeCurrentAction &&   $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 5 ) // is employee
            $this->employeeRejectRequest($params , $CurrentLoggedInUserId , $groupentity ); 
            else
            $this->userRejectRequest($params , $CurrentLoggedInUserId , $groupentity , $userentity , $currentActionLog );  
        }
        else if(isset($params['sendtoemployee']))
        { 
            if ( $nonHrCanTakeCurrentAction &&  ( $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 3   || $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 2) ) // is moderator
            $this->moderatorSendToEmployee($params , $CurrentLoggedInUserId , $userentity , $groupentity );
            
            elseif( ($currentActionLog[0]['assignedToRole'] == 6) &&  $hrCanTakeCurrentAction &&  $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) )) // is training responsible 
            $this->userSendToEmployee($params , $CurrentLoggedInUserId , $userentity );
        }
        else if(isset($params['accept']) || isset($params['save']))
        {
             if ( !is_null($currentActionLog[0]['forwardedToUser']) && $nonHrCanTakeCurrentAction &&   $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->currentUserRole( $userid ,  $groupid) == 5 ) // is employee
            $this->employeeAcceptRequest($params , $CurrentLoggedInUserId , $groupentity ); 
        }
        else if(isset($params['assignto']))
        {// Training Department Responsible assign to Training Specialist
            $this->AssignToTrainingSpecialist($params , $CurrentLoggedInUserId , $groupentity ); 
        }
        else if(isset ($params['sendtomoderator']))
        { 
            $this->employeeSendToModerator($params , $CurrentLoggedInUserId , $groupentity ); 
        }
    }
    
 
    private function employeeRejectRequest($params , $CurrentLoggedInUserId  , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
    
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
 

    
        $currentRoleId     = 5; // is an employee 
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('reject');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
         // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($groupentity->getIdGroup() , array(3) ))
        foreach ($moderatorData as $k => $v)
        {
             
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail') );

        }
        
    }
    
    
    private function userRejectRequest($params , $CurrentLoggedInUserId  , \Tatweer\TrainingBundle\Entity\Groups $groupentity , Users $userentity , $currentActionLog )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $currentUserGroup  = $groupentity->getIdGroup();
        if($currentActionLog[0]['assignedToRole'] == 6 && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) )) // is training responsible 
        {
            $currentRoleId = 6;
            $currentgroup  = $groupentity->getIdGroup();
            $groupentity   = NULL;
        }
        elseif($currentActionLog[0]['assignedToRole'] == 8 && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(8) )) // is training manager
        {
            $currentRoleId = 8;
            $currentgroup  = $groupentity->getIdGroup();
            $groupentity   = NULL;
        }
        elseif($currentActionLog[0]['assignedToRole'] == 9 && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(9) )) // is training manager
        {
            $currentRoleId = 9;
            $currentgroup  = $groupentity->getIdGroup();
            $groupentity   = NULL;
        }
        else 
        {
            // then check if the current logged in user has manager or moderator role on this group or its parent 
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentRoleId  = $currentPermissions[0]['roleid'];
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }
        }
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('reject');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        if( $currentRoleId == 9 ) // hr manager 
        $TrainingNeed->setIsFinallyApproved(0);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // send notificaton email 
        $this->sendEmail( $userentity->getUsername() ,  'trainingneedreject' , $this->translator->trans('Training request rejected', array(), 'mail'));

       
        if($currentRoleId != 3 ) // not the moderator who reject the request
        {
        // send mails to the direct and indirect moderators 
        if($users = $em->getRepository('TatweerTrainingBundle:Users')->getDirectIndirectModerators($currentUserGroup))  
        foreach ($users as $k => $v)
        {
            $this->sendEmail( $v ,  'moderator_rejection_notification' ,  $this->translator->trans('Training needs rejected', array(), 'mail') );
        }
        }
        
        if( $currentRoleId == 8 ||  $currentRoleId == 9 ) // training manager  or  hr manager 
        {
            // then training responsible should be notified with an email 
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'training_department_rejection_notification' , $this->translator->trans('Training needs rejected', array(), 'mail'));
        }
        }
        
        
        if( $currentRoleId == 9 ) // hr manager 
        {
            // then training responsible should be notified with an email 
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(8)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'training_department_rejection_notification' , $this->translator->trans('Training needs rejected', array(), 'mail') );
        }
        }
        
        
    }
    
    
    private function employeeAcceptRequest($params , $CurrentLoggedInUserId  , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentRoleId  = $currentPermissions[0]['roleid'];
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }
        else 
        $currentRoleId     = 5; // is an employee 
        
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($groupentity);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
    
         // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($groupentity->getIdGroup() , array(3)))
        foreach ($moderatorData as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail'));

        }
        
        
    }
    
    
    
    private function employeeSendToModerator($params , $CurrentLoggedInUserId  , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
     
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentRoleId  = $currentPermissions[0]['roleid'];
            if($currentRoleId != 5 )
            {
                // get group parent 
                if($groupParent     = $em->getRepository('TatweerTrainingBundle:Groups')->get_parent($currentPermissions[0]['groupid']))
                   $currentGroupId  = $groupParent[0]['parent'];  
                
            }
            else
            $currentGroupId = $currentPermissions[0]['groupid'];
            
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }
        else 
         $currentRoleId     = 5; // is an employee 
        
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('forward');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($groupentity);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($groupentity->getIdGroup() , array(3)))
        foreach ($moderatorData as $k => $v)
        {
            echo $v['username'];
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail'));

        }
        
        
    }
    
    private function moderatorSendToEmployee($params , $CurrentLoggedInUserId  , Users $userentity , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
 
        // check if the current logged in user is not the same actor 
        if($CurrentLoggedInUserId != $TrainingNeed->getRequestedForEmployee()->getIdUser())
        {
            // then check if the current logged in user has manager or moderator role on this group or its parent 
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentRoleId  = $currentPermissions[0]['roleid'];
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }
        
        
        }
        else // if not 
        {
        $currentRoleId     = 5; // is an employee 
        }
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('forward');
        $actionLog->setForwardedToUser($userentity);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
         // send notificaton email 
        $this->sendEmail( $userentity->getUsername() ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail') );

        
    }
    
    private function moderatorSendBackRequest($params , $CurrentLoggedInUserId  , Users $userentity , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $assignToGroup     = new Groups();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
  
        $assignToGroupId   = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->levelDownTrainingRequest($params['trainingneed_id']);
        $assignToGroup     = $em->getRepository('TatweerTrainingBundle:Groups')->find($assignToGroupId);
        
        // get current user role in selected group 
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentRoleId  = $currentPermissions[0]['roleid'];
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }

        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find($currentRoleId);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($assignToGroup);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
       
      // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($assignToGroup->getIdGroup() , array(3)))
        foreach ($moderatorData as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail'));

        }
          
        
    }
    
    private function departmentManagerSendBackRequest($params , $CurrentLoggedInUserId  , Users $userentity , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $assignToGroup     = new Groups();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
  
        $assignToGroupId   = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->levelDownTrainingRequest($params['trainingneed_id']);
        $assignToGroup     = $em->getRepository('TatweerTrainingBundle:Groups')->find($assignToGroupId);
        

        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(2);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($assignToGroup);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
       
      // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($assignToGroup->getIdGroup() , array(3)))
        foreach ($moderatorData as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail'));

        }
          
        
    }
    
    private function moderatorApproveRequest($params , $CurrentLoggedInUserId  , Users $userentity , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $assignToGroup     = new Groups();
  
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
  
        $assignToGroupId   = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->levelUpTrainingRequest($params['trainingneed_id']);
        $assignToGroup     = $em->getRepository('TatweerTrainingBundle:Groups')->find($assignToGroupId);
        
        // get current user role in selected group 
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }

        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(3);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($assignToGroup);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
       // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
        // send notificaton email 
        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($assignToGroup->getIdGroup() , array(2,3)))
        foreach ($moderatorData as $k => $v)
        {
                $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training details review', array(), 'mail'));
                
        }
          
        
    }
    
    private function departmentManagerApproveRequest($params , $CurrentLoggedInUserId  , Users $userentity , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
   
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
  
        
        // get current user role in selected group 
        if($currentPermissions     = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup($groupentity->getIdGroup() , $CurrentLoggedInUserId ))
        {
            $currentGroupId = $currentPermissions[0]['groupid'];
            $groupentity    = $em->getRepository('TatweerTrainingBundle:Groups')->find($currentGroupId); 
        }

        $roleObj               = $em->getRepository('TatweerTrainingBundle:Roles')->find(2);
        $assignToRole          = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup($groupentity);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
       // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
       // send notificaton email 
   
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingdepartmentreview', $this->translator->trans('Training requests review', array(), 'mail') );

        }
          
        
    }
    
    private function AssignToTrainingSpecialist($params , $CurrentLoggedInUserId  , \Tatweer\TrainingBundle\Entity\Groups $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        $trainingSpecialistObj = $em->getRepository('TatweerTrainingBundle:Users')->find($params['training_specialist']);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('forward');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist($trainingSpecialistObj);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
   
         // send notificaton email 
           $this->sendEmail( $trainingSpecialistObj->getUsername() ,  'trainingdepartmentreview' ,  $this->translator->trans('Training requests review', array(), 'mail'));
   
    }
    
    private function trainingSpecialistSendBackRequest($params , $CurrentLoggedInUserId )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(7);
        $assignToRole      = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 

   
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
               $this->sendEmail( $v['username'] ,  'trainingdepartmentreview', $this->translator->trans('Training requests review', array(), 'mail') );

        }
        
        
    }
    private function userSendToEmployee($params , $CurrentLoggedInUserId  , Users $userentity )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
 
        if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6) )) // is training responsible 
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('forward');
        $actionLog->setForwardedToUser($userentity);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
         // send notificaton email 
           $this->sendEmail( $userentity->getUsername() ,  'trainingneedreview' ,  $this->translator->trans('Training details review', array(), 'mail'));

        
    }
    private function trainingResponsibleApproveRequest($params , $CurrentLoggedInUserId )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
  
        

        $roleObj               = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        $assignToRole          = $em->getRepository('TatweerTrainingBundle:Roles')->find(8);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
    
       // send notificaton email 
   
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(8)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
               $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail'));
 
        }
          
        
    }
    
 
    private function trainingManagerSendBackRequest($params , $CurrentLoggedInUserId )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(8);
        $assignToRole      = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 

   
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
               $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail'));

        }
        
        
    }
    
 
    private function trainingResponsibleSendBackRequest($params , $CurrentLoggedInUserId , $groupentity)
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();

 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        $userGroup         = $groupentity->getIdGroup();
                
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
        if($groupParent = $em->getRepository('TatweerTrainingBundle:Departments')->getDepartmentOfGroup($groupentity->getIdGroup()))
        {
           $groupentity = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupParent);
        }
                       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup($groupentity);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 

        if($moderatorData = $em->getRepository('TatweerTrainingBundle:Users')->getUserByGroupRole($userGroup , array(3)))
        foreach ($moderatorData as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingneedreview' , $this->translator->trans('Training requests review', array(), 'mail'));

        }
        
        
    }
    
    private function trainingManagerApproveRequest($params , $CurrentLoggedInUserId )
    {
        $em                  = $this->entityManager;
        $actionLog           = new TrainingNeedsActionsLog();
        $TrainingNeed        = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
  
        $hasTrainingDetailes = $em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($params['trainingneed_id']);
        $individualTraining  = $em->getRepository('TatweerTrainingBundle:Trainings')->isIndividualTraining($params['trainingneed_id']);
        $TrainingNeed        = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj            = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj             = $em->getRepository('TatweerTrainingBundle:Roles')->find(8);
        
        if($hasTrainingDetailes || $individualTraining)
        $assignToRole        = $em->getRepository('TatweerTrainingBundle:Roles')->find(9);   
        else 
        $assignToRole        = $em->getRepository('TatweerTrainingBundle:Roles')->find(6);
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 

        if($hasTrainingDetailes)
        $TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(9));
        else 
        $TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6));
        if($TrainingDepartmentResponsible)
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail'));

        }
        
        
    }

    private function hrManagerSendBackRequest($params , $CurrentLoggedInUserId )
    {
        $em                = $this->entityManager;
        $actionLog         = new TrainingNeedsActionsLog();
        $TrainingNeed      = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
 
        $TrainingNeed      = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj           = $em->getRepository('TatweerTrainingBundle:Roles')->find(9);
        $assignToRole      = $em->getRepository('TatweerTrainingBundle:Roles')->find(8);
    
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('feedback');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole($assignToRole);
        $actionLog->setAssignedToTrainingSpecialist(NULL);
        
        $TrainingNeed->setModifiedBy($actorObj);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 

   
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(8)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail'));

        }
        
        
    }
    
     
    private function hrManagerApproveRequest($params , $CurrentLoggedInUserId , $userid , $groupid , $userentity )
    {
        $em                  = $this->entityManager;
        $actionLog           = new TrainingNeedsActionsLog();
        $TrainingNeed        = new TrainingNeeds();
        $trainingSpecialistObj = new Users();
 
        $hasTrainingDetailes = $em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($params['trainingneed_id']);
        $TrainingNeed        = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($params['trainingneed_id']);
        $actorObj            = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $roleObj             = $em->getRepository('TatweerTrainingBundle:Roles')->find(9);
        $individualTraining  = $em->getRepository('TatweerTrainingBundle:Trainings')->isIndividualTraining($params['trainingneed_id']);
            
        
        $actionLog->setActor($actorObj);
        $actionLog->setActorRole($roleObj);
        $actionLog->setActorGroup(NULL);
        $actionLog->setCreatedBy($CurrentLoggedInUserId);
        
        // set actor comment 
        if(isset($params['comment']) && !empty($params['comment']))
        $actionLog->setActorComment($params['comment']);
        if(isset($params['selected_budget']))
        $departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->find($params['selected_budget']);
       
        // get training need 
        
        $actionLog->setTrainingNeed($TrainingNeed);
        
        $actionLog->setAction('approve');
        $actionLog->setForwardedToUser(NULL);
        $actionLog->setAssignedToGroup(NULL);
        $actionLog->setAssignedToRole(NULL);
        $actionLog->setAssignedToTrainingSpecialist(NULL);

        $TrainingNeed->setModifiedBy($actorObj);
        $TrainingNeed->setIsFinallyApproved(1);
        $em->flush(); 
        
        $em->persist($actionLog);
        $em->flush(); 
        
                
        // get selected program total costs
        if( !($trainingId = $individualTraining) )  
        $trainingId  = $em->getRepository('TatweerTrainingBundle:Trainings')->getSelectedTraining($groupid , $userid);
   
        $trainings = new Trainings();
        $trainings = $em->getRepository('TatweerTrainingBundle:Trainings')->find($trainingId);
        $trainings->setApprovedByHr(1);
        $trainings->setModifiedBy($actorObj);
        $trainings->setDepartmentBudget($departmentBudget);
        $em->flush(); 
        
        // GHAIDAA DONT FORGET TO UNCOMMENT THIS -> TO SEND NOTIFICATION MAILES 
         // send notificaton email 
        $this->sendEmail( $userentity->getUsername() ,  'trainingneedreview' , $this->translator->trans('Training requests review', array(), 'mail') );
       

        // send mails to the direct and indirect moderators 
        if($users = $em->getRepository('TatweerTrainingBundle:Users')->getDirectIndirectModerators($groupid))
        foreach ($users as $k => $v)
        {
            $this->sendEmail( $v ,  'trainingdepartmentreview' , $this->translator->trans('Training details review', array(), 'mail')  );
        }
        
        

            // then training responsible should be notified with an email 
        if($TrainingDepartmentResponsible = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(6)))
        foreach ($TrainingDepartmentResponsible as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail'));
        }
        
       
            // then training manager should be notified with an email 
        if($TrainingDepartmentManager = $em->getRepository('TatweerTrainingBundle:Users')->getUserByRole( array(8)))
        foreach ($TrainingDepartmentManager as $k => $v)
        {
            $this->sendEmail( $v['username'] ,  'trainingdepartmentreview' , $this->translator->trans('Training requests review', array(), 'mail') );
        }

        
        
        
        
    }
    
    private function sendEmail( $tousername ,  $template , $subject )
    {
        
        $userDataFromAD = $this->activeDirectory->getUserResults(array('username' => $tousername));
        
        $fullname = ($this->locale == 'ar' ? $userDataFromAD->FullArabicName : $userDataFromAD->DisplayName);
   
        $this->mailer->sendEmail('delivery@t4edu.com', $userDataFromAD->Email ,             
            $this->templating->render(
                'TatweerTrainingBundle:MailTemplates:'.$template.'.html.twig',
                array('name' => $fullname ) 
            )
            , $subject
            );
    }
}
