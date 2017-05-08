<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrainingNeedsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrainingNeedsRepository extends EntityRepository
{
    

    const REJECTED = 0;
    const APPROVED = 1;
    const FEEDBACK = 2;
    const FORWARD = 3;
    //...........

    const CAN_APPROVE = 1;
    const CAN_REJECT = 2;
    const CAN_FEEDBACK = 3;
    const CAN_SEND_TO_EMPLOYEE = 4;
    const CAN_ASSIGN_TO = 5;
    const CAN_ACCEPT = 6;
    const CAN_SAVE = 7;
    const CAN_SENT_TO_MODERATOR = 8;
    const CAN_SEND_BACK_TO_EMPLOYEE = 9;
    

    const DEPARTMENT_RESPONSIBLES_TEAM = 1;  // if moderator or departmnet managers 
    const TRAINING_HR_RESPONSIBLES_TEAM = 2; // if training responsible , specialist , manager or hr manager 
    //...........
    const ADMIN = 1;
    const DEPARTMENT_MANAGER = 2;
    const MODERATOR = 3;
    const STRUCTURE_RESPONSIBLE = 4;
    const EMPLOYEE = 5;
    const TRAINING_RESPONSIBLE = 6;
    const TRAINING_SPECIALIST = 7;
    const TRAINING_MANAGER = 8;
    const HR_MANAGER = 9;
    

 
    
    
 /*
  *  
  * buildForm
  * build the rtaining need request Form
  * @params : 
  * $evaluationID : integer 
  * return : form , array  
  */
    public function buildForm($evaluationID = null )
    {
    
        $em          = $this->getEntityManager();
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeedsOptions', 'o')
          ->select("o")
          ->where("o.deleted = 0")
          ->addOrderBy("o.idOption", "ASC")
          ->getQuery();
        $form['optionsResult'] = $query->getArrayResult();
        
        if(!is_null($evaluationID))
        {
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeedsValues', 'v')
          ->select("v.idValue , IDENTITY(v.selectedOption) AS selectedOption , v.valueAr , v.valueEn , IDENTITY(v.trainingNeed) AS trainingNeed , v.section ")
          //->leftJoin('TatweerTrainingBundle:EmployeesEvaluationValues', 'v', 'WITH', 'v.criteria = c.idCriteria')
          ->where("v.trainingNeed = ".$evaluationID)
          ->addOrderBy("v.idValue", "ASC")
          ->getQuery();
         $form['valuesResult'] = $query->getArrayResult();
        }

        
        return $form;
    }
    
    public function getUserTrainingNeedsRequests($userId , $periodId )
    {
        $em          = $this->getEntityManager();

        $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeeds', 't')
          ->select(" t.idNeed , t.modifiedDate , IDENTITY(t.employeeGroup) AS employeeGroup , IDENTITY(t.requestedForEmployee) AS requestedForEmployee , IDENTITY(t.modifiedBy) AS modifiedBy   , u.username AS modifiedByUser ")
          //->leftJoin('TatweerTrainingBundle:TrainingNeedsActionsLog', 'a', 'WITH', 'a.trainingNeed = t.idNeed')
           
          ->leftJoin('TatweerTrainingBundle:Users', 'u', 'WITH', 'u.idUser = t.modifiedBy')
          ->where("t.requestedForEmployee = ".$userId ." AND t.trainingneedPeriod = ".$periodId )
          ->getQuery();
        
        $results = $query->getArrayResult();
        foreach ($results as $k => $v)
        {
            if($this->getCurrentAction($v['idNeed']))
            {
            if($em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($v['idNeed']))
                unset ($results[$k]);
                else
                $results[$k]['status'] = $this->getCurrentAction($v['idNeed']);
            }
            else 
            unset ($results[$k]);
            
            
        }

        return $results;
    }
    public function getUserTrainingNeedsRequestsWithDetailes($userId , $periodId )
    {
        $em          = $this->getEntityManager();

        $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeeds', 't')
          ->select(" t.idNeed , t.modifiedDate , IDENTITY(t.employeeGroup) AS employeeGroup , IDENTITY(t.requestedForEmployee) AS requestedForEmployee , IDENTITY(t.modifiedBy) AS modifiedBy   , u.username AS modifiedByUser ")
          //->leftJoin('TatweerTrainingBundle:TrainingNeedsActionsLog', 'a', 'WITH', 'a.trainingNeed = t.idNeed')
           
          ->leftJoin('TatweerTrainingBundle:Users', 'u', 'WITH', 'u.idUser = t.modifiedBy')
          ->where("t.requestedForEmployee = ".$userId ." AND t.trainingneedPeriod = ".$periodId )
          ->getQuery();
        
        $results = $query->getArrayResult();
        foreach ($results as $k => $v)
        {
            if($this->getCurrentAction($v['idNeed']))
            {
            if($em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($v['idNeed']))
                $results[$k]['status'] = $this->getCurrentAction($v['idNeed']);
            else
                unset ($results[$k]);
            }
            else 
            unset ($results[$k]);
            
        }

        return $results;
    }
    public function getUserActionLogHistory($trainingneedID , $groupid)
    {
        $em          = $this->getEntityManager();

        $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeedsActionsLog', 'a')
          ->select("a.idAction, a.action, a.actorComment, a.createdDate,  a.createdBy  , IDENTITY(a.actor) AS actor , IDENTITY(a.forwardedToUser) AS forwardedToUser , IDENTITY(a.assignedToRole) AS assignedToRole , IDENTITY(a.assignedToGroup) AS assignedToGroup , IDENTITY(a.assignedToTrainingSpecialist) AS assignedToTrainingSpecialist "
                  . ", u.username , u.arabicFullname AS FullArabicName , u.englishFullname AS DisplayName , r.nameAr , r.nameEn , IDENTITY(t.requestedForEmployee) AS requestedForEmployee "
                  . ", g.name AS groupName "
                  . ", ru.username AS requestedForEmployeeUsername ,  ru.arabicFullname AS requestedForEmployeeFullArabicName , ru.englishFullname AS requestedForEmployeeDisplayName "
                  . ", er.nameAr AS employeeRoleAr , er.nameEn AS employeeRoleEn "
                  . ", ts.nameAr AS tSpecialistRoleAr , ts.nameEn AS tSpecialistRoleEn "
                  . ", gr.nameAr AS groupRoleAr , gr.nameEn AS groupRoleEn "
                  . ", to.username AS trainingSpecialistUsername , to.arabicFullname AS trainingSpecialistFullArabicName , to.englishFullname AS trainingSpecialistDisplayName")
          ->leftJoin('TatweerTrainingBundle:Users', 'u', 'WITH', 'u.idUser = a.actor')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 't', 'WITH', 't.idNeed = a.trainingNeed')
          ->leftJoin('TatweerTrainingBundle:Groups', 'g', 'WITH', 'a.assignedToGroup = g.idGroup')
          ->leftJoin('TatweerTrainingBundle:Roles', 'r', 'WITH', 'r.idRole = a.actorRole ')
          ->leftJoin('TatweerTrainingBundle:Roles', 'gr', 'WITH', 'gr.idRole = a.assignedToRole')
          ->leftJoin('TatweerTrainingBundle:Users', 'to', 'WITH', 'to.idUser = a.assignedToTrainingSpecialist')
          ->leftJoin('TatweerTrainingBundle:Users', 'ru', 'WITH', 'ru.idUser = t.requestedForEmployee')  
          ->leftJoin('TatweerTrainingBundle:Roles', 'er', 'WITH', 'er.idRole = 5 ')
          ->leftJoin('TatweerTrainingBundle:Roles', 'ts', 'WITH', 'ts.idRole = 7 ')
          ->where("a.trainingNeed = :trainingneedid " )
          ->orderBy('a.idAction', 'DESC')
          ->setParameter( 'trainingneedid' , $trainingneedID )
          ->getQuery();
       //print_r($query->getArrayResult());
        return $query->getArrayResult();
        
    }
    
    
    
    public function getCurrentAction($trainingneedID)
    {
        $em          = $this->getEntityManager();
        //get training need status
        $query= $this->getEntityManager()->createQuery(
           'SELECT a.action FROM TatweerTrainingBundle:TrainingNeedsActionsLog a 
            WHERE a.trainingNeed = :trainingneedid 
            Order by a.idAction DESC
            '
        )->setParameter( 'trainingneedid' , $trainingneedID )->setMaxResults(1);
        if($actionLog_data = $query->getArrayResult())
        return  $actionLog_data[0]['action'];
        else 
            return null;
    }
    
    
    
    
    public function getStatus($trainingneedID) {
 
        $em          = $this->getEntityManager();
        
        //check training need status
        $action = $this->getCurrentAction($trainingneedID);
        
        
        if ($action == 'reject' ) {
            return TrainingNeedsRepository::REJECTED;
        } elseif ($action == 'approve') {
            return TrainingNeedsRepository::APPROVED;
        } elseif ($action == 'feedback') {
            return TrainingNeedsRepository::FEEDBACK;
        } elseif ($action == 'forward') {
            return TrainingNeedsRepository::FORWARD;
        }
    }
    
    public function currentUserRole($userId ,  $group_id )
    {
        
        $em                    = $this->getEntityManager();
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        
        if ($userId == $CurrentLoggedInUserId )            return 5; // is employee role 
        else
        {
            // if logged in user has (moderator or dep manager ) permission on this group 
            if($currentPermissions    = $em->getRepository('TatweerTrainingBundle:Users')->checkUserRoleInGroup( $group_id , $CurrentLoggedInUserId))
                return $currentPermissions[0]['roleid']; // is moderator or department manager 
            // else if the current user is trainer or Hr use 
           // elseif( $em->getRepository('TatweerTrainingBundle:Users')->hasPermission($groupId , $roleIds))
        }
        
        return false;
    }
    
    
    public function allowedActions($userId ,  $group_id , $trainingneedID = null , $isTrainerHr = false , $isIndiviualTraining = false ) {
        
        $actions     = array();
        $em          = $this->getEntityManager();
        $actionLog_data = $this->getCurrentActionLogData($trainingneedID);
        $isAlreadyApprovedByTrainingManager =  $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->isAlreadyApprovedByTrainingManager($trainingneedID);
     
        
        
        if ( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::EMPLOYEE && !$isTrainerHr) {
             
            
            if($isIndiviualTraining)
            {
            $actions[] = TrainingNeedsRepository::CAN_SENT_TO_MODERATOR;
            }
            else 
            {
            
           // check if there is a training detailes 
            $hasTrainingDetailes = $em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($trainingneedID);
        
            if(!$hasTrainingDetailes && !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_ACCEPT;
            
            if(!$hasTrainingDetailes && !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
            
            if($hasTrainingDetailes)
            $actions[] = TrainingNeedsRepository::CAN_SAVE;
            
            }
            
        } elseif ( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::MODERATOR && !$isTrainerHr) {
        // check if there is a training detailes 
        $hasTrainingDetailes = $em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($trainingneedID);
        
            // check if this group has a sub-groups -> then allow feedback to send the training details back to the sub-groups moderator 
            if(! is_null($trainingneedID) && $this->levelDownTrainingRequest($trainingneedID) )
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
            $actions[] = TrainingNeedsRepository::CAN_APPROVE;
            

            if($isIndiviualTraining)
            {
            if(($em->getRepository('TatweerTrainingBundle:Users')->hasPermission($group_id , array(3))) )
            $actions[] = TrainingNeedsRepository::CAN_SEND_BACK_TO_EMPLOYEE;  
            }
            else 
            {
            if(($em->getRepository('TatweerTrainingBundle:Users')->hasPermission($group_id , array(3))) )
            $actions[] = TrainingNeedsRepository::CAN_SEND_TO_EMPLOYEE;  
            }
            
            
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
            
        } elseif ( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::DEPARTMENT_MANAGER && !$isTrainerHr) {
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
            $actions[] = TrainingNeedsRepository::CAN_APPROVE; 
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
            if($isIndiviualTraining)
            {
            $actions[] = TrainingNeedsRepository::CAN_SEND_BACK_TO_EMPLOYEE;  
            }
            
        }
        elseif ($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(TrainingNeedsRepository::TRAINING_RESPONSIBLE && $isTrainerHr && $actionLog_data[0]['assignedToRole'] == TrainingNeedsRepository::TRAINING_RESPONSIBLE ))) {
        // check if there is a training detailes 
      
        $hasTrainingDetailes = $em->getRepository('TatweerTrainingBundle:Trainings')->hasTrainingDetailes($trainingneedID);
        
            if($hasTrainingDetailes || !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
            
            if($hasTrainingDetailes || !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_APPROVE; 
            
            if(!$hasTrainingDetailes && !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_ASSIGN_TO; 
            
            if($hasTrainingDetailes || !$isAlreadyApprovedByTrainingManager)
            {
            if(!$isIndiviualTraining)
            $actions[] = TrainingNeedsRepository::CAN_SEND_TO_EMPLOYEE;  
            }
            
            if($hasTrainingDetailes || !$isAlreadyApprovedByTrainingManager)
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
        }
        elseif ($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(TrainingNeedsRepository::TRAINING_SPECIALIST && $isTrainerHr && !is_null($actionLog_data[0]['assignedToTrainingSpecialist']) ))) {
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
        }
        elseif ($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(TrainingNeedsRepository::TRAINING_MANAGER && $isTrainerHr && $actionLog_data[0]['assignedToRole'] == TrainingNeedsRepository::TRAINING_MANAGER))) {
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
            $actions[] = TrainingNeedsRepository::CAN_APPROVE; 
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
        }
        elseif ($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(TrainingNeedsRepository::HR_MANAGER && $isTrainerHr && $actionLog_data[0]['assignedToRole'] == TrainingNeedsRepository::HR_MANAGER))) {
            $actions[] = TrainingNeedsRepository::CAN_FEEDBACK;
            $actions[] = TrainingNeedsRepository::CAN_APPROVE; 
            $actions[] = TrainingNeedsRepository::CAN_REJECT;
        }  
        
        return $actions;
    }
    

    public function canDoNextAction($trainingneedID )
    {
        $em          = $this->getEntityManager();
        
        if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        { 
         $user_roles = $em->getRepository('TatweerTrainingBundle:Users')->checkUserGroup($actionLog_data[0]['assignedToGroup']);
            if( ! $user_roles )
                return false; 
            else 
                return $user_roles;    
        }
        return false; 
    }
    
    
    
    public function canTakeAction($trainingneedID , $userId ,  $group_id , $isIndiviualTraining = false ) {
 
        $em          = $this->getEntityManager();
        
        //check training need status
        $action = $this->getCurrentAction($trainingneedID);
        
  
        // if no training need -> return false 
        if ( ! $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingneedID) ) {
            return false;
        } 
        // if there is a training need and without actions and is not Indiviual Training
        elseif( $action == null && $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingneedID) && ($this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::MODERATOR ) && !$isIndiviualTraining )
        {
            return true;
        }
        // if there is a training need and without actions and is Indiviual Training
        elseif( $action == null && $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingneedID) && ($this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::EMPLOYEE ) && $isIndiviualTraining )
        {
            return true;
        }
        elseif ($action == 'reject' ) {
            return false;
        }
        //
        if( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::DEPARTMENT_MANAGER )
        {
        $user_roles = $this->canDoNextAction($trainingneedID);
        if($user_roles && in_array(TrainingNeedsRepository::DEPARTMENT_MANAGER, $user_roles)) return true;
        
        return false;
        }
        
        elseif( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::MODERATOR  )
        { 
        $user_roles = $this->canDoNextAction($trainingneedID);
        if($user_roles && in_array(TrainingNeedsRepository::MODERATOR, $user_roles)) return true;
        
        return false;
        }
        
        elseif( $this->currentUserRole($userId ,  $group_id ) == TrainingNeedsRepository::EMPLOYEE )
        {
       
        if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        { 
                if( $actionLog_data[0]['forwardedToUser'] == $userId)
                return true;    
        }
      
        return false;
        
        }
       // else
      //  {
 
       /* if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        { 
                if( $actionLog_data[0]['assignedToTrainingSpecialist'] == $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId())
                return true;    
                elseif(!is_null($actionLog_data[0]['assignedToRole'])  && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array($actionLog_data[0]['assignedToRole']) ) )
                return true;
        }
      
        return false;
        */
       // }
        
    }

        public function canTakeTrainerHrAction($trainingneedID , $userId ,  $group_id ) {
 
        $em          = $this->getEntityManager();
        
        //check training need status
        $action = $this->getCurrentAction($trainingneedID);
        
  

        if ($action == 'reject' ) {
            return false;
        }
 
        if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        { 
                if( $actionLog_data[0]['assignedToTrainingSpecialist'] == $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId())
                return true;    
                elseif(!is_null($actionLog_data[0]['assignedToRole'])  && $em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array($actionLog_data[0]['assignedToRole']) ) )
                return true;
        }
      
        return false;
        
       // }
        
    }
    
    
    public function levelUpTrainingRequest($trainingneedID)
    {
        $em          = $this->getEntityManager();
 
        if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        {
         $group_id  = $actionLog_data[0]['assignedToGroup'];
 
         if( $parent = $em->getRepository('TatweerTrainingBundle:Groups')->get_parent($group_id))
         {   if($parent[0]['parent'])
             return $parent[0]['parent'];
         else 
             return FALSE;
         }
         else 
           return $group_id;  
        }
        
         return FALSE;
    }
    
    public function levelDownTrainingRequest($trainingneedID)
    {
        $em          = $this->getEntityManager();
        //get training need status
 
       
        if($actionLog_data = $this->getCurrentActionLogData($trainingneedID))
        {
         $group_id  = $actionLog_data[0]['assignedToGroup'];
         if( $parent = $em->getRepository('TatweerTrainingBundle:Groups')->get_child($group_id))
         {
              if($parent[0]['idGroup'])
             return $parent[0]['idGroup'];
              else 
              return FALSE;
         }
        }
        return FALSE;
    }
    
    
    
    public function getCurrentActionLogData($trainingneedID)
    {
        $em          = $this->getEntityManager();
        $query= $this->getEntityManager()->createQuery(
           'SELECT IDENTITY(a.forwardedToUser) AS  forwardedToUser ,
                   IDENTITY(a.assignedToGroup) AS  assignedToGroup ,
                   IDENTITY(a.assignedToRole) AS  assignedToRole ,
                   IDENTITY(a.assignedToTrainingSpecialist) AS  assignedToTrainingSpecialist 
            FROM TatweerTrainingBundle:TrainingNeedsActionsLog a 
            WHERE a.trainingNeed = :trainingneedid 
            Order by a.idAction DESC 
            '
        )
        ->setParameter( 'trainingneedid' , $trainingneedID )
        ->setMaxResults(2);  
        return  $query->getArrayResult();
    }
    
    
    
    
    public function isApprovedByTrainingDepartment($trainingneedID)
    {
        $em          = $this->getEntityManager();
        $query= $this->getEntityManager()->createQuery(
           'SELECT IDENTITY(a.assignedToRole) AS  assignedToRole ,
               a.action 
            FROM TatweerTrainingBundle:TrainingNeedsActionsLog a 
            WHERE a.trainingNeed = :trainingneedid 
            Order by a.idAction DESC 
            '
        )
        ->setParameter( 'trainingneedid' , $trainingneedID )
        ->setMaxResults(1)
        ->setFirstResult(1);
                
        if($trainingStatus = $query->getArrayResult())
        {
            // check if is approved by training manager 
        if( ($trainingStatus[0]['assignedToRole'] == TrainingNeedsRepository::TRAINING_MANAGER) && ($this->getStatus($trainingneedID) == TrainingNeedsRepository::APPROVED ) )
            return true;
        else 
            return false;
        }
        
        return false;
    }
    
    
    
    public function isAlreadyApprovedByTrainingManager($trainingneedID)
    {
            
        $em          = $this->getEntityManager();
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeedsActionsLog', 'a')
          ->select("a")
          ->where("a.action = 'approve' AND a.actorRole = 8 AND a.trainingNeed = :need_id ")
          ->setParameter('need_id', $trainingneedID)
          ->getQuery();
        return $query->getArrayResult();
    }
    
    public function hasDetails($training_need_id)
    {
        
        //trainingNeedsProgram TrainingNeedsValues
        $em          = $this->getEntityManager();
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t")
          ->Join('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 't.trainingNeedsProgram = v.idValue')
          ->Join('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
          
          ->where("n.idNeed = ".$training_need_id .' AND t.chosenByEmployee = 1')
          ->getQuery();
         if($query->getArrayResult())
             return true;
         
         return false;
             
    }
    
    public function assignedActorType($trainingneed_id)
    {
        $actionLog_data = $this->getCurrentActionLogData($trainingneed_id);
        
        // if is group moderator or department manager
        if(isset($actionLog_data[1]) &&  $actionLog_data[1]['assignedToGroup']  &&   ! $actionLog_data[1]['assignedToTrainingSpecialist']
               && ! $actionLog_data[1]['assignedToRole'] &&   ! $actionLog_data[1]['forwardedToUser'] )
            return TrainingNeedsRepository::DEPARTMENT_RESPONSIBLES_TEAM;
        
        // if is training specialist
        elseif(isset($actionLog_data[1]) &&  ! $actionLog_data[1]['assignedToGroup']  &&    $actionLog_data[1]['assignedToTrainingSpecialist']
               && ! $actionLog_data[1]['assignedToRole'] &&   ! $actionLog_data[1]['forwardedToUser'] )
            return TrainingNeedsRepository::TRAINING_HR_RESPONSIBLES_TEAM;
           // return $actionLog_data[0]['assignedToTrainingSpecialist'];
        
        // if is training responcible or manager or hr manager
        elseif(isset($actionLog_data[1]) &&  ! $actionLog_data[1]['assignedToGroup']  &&    ! $actionLog_data[1]['assignedToTrainingSpecialist']
               &&  $actionLog_data[1]['assignedToRole'] &&   ! $actionLog_data[1]['forwardedToUser'] )
            return TrainingNeedsRepository::TRAINING_HR_RESPONSIBLES_TEAM;
        
        // if is employee
        elseif(isset($actionLog_data[1]) &&  ! $actionLog_data[1]['assignedToGroup']  &&    ! $actionLog_data[1]['assignedToTrainingSpecialist']
               && ! $actionLog_data[1]['assignedToRole'] &&    $actionLog_data[1]['forwardedToUser'] )
            return TrainingNeedsRepository::EMPLOYEE;
           // return $actionLog_data[0]['forwardedToUser'];
        
        
            return false;
    }

    
    
}
