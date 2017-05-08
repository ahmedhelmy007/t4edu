<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrainingsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrainingsRepository extends EntityRepository
{
/* 
 Get user training data " requested by HR " 
 @params : 
 * $groupid : user group 
 * $userid  : user id
 *  */
    public function getUserTraining($groupid , $userid)
    {
        
      $em          = $this->getEntityManager();
      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select(" IDENTITY(t.language) AS language ,t.idTraining, t.name, t.providerName, t.startDate, t.endDate, t.duration, c.nameAr AS countryAr , c.nameEn AS countryEn, t.city, t.approvedByHr, t.languageOther, t.createdDate"
                  . " , v.valueAr , v.valueEn "
                  . " , IDENTITY(n.requestedForEmployee) AS idUser , IDENTITY(n.employeeGroup) AS idGroup "
                  . " , l.nameAr As langAr , l.nameEn As langEn ")
          ->leftJoin('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 'v.idValue = t.trainingNeedsProgram')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
          ->leftJoin('TatweerTrainingBundle:Countries', 'c', 'WITH', 'c.id = t.country')
          ->leftJoin('TatweerTrainingBundle:Languages', 'l', 'WITH', 'l.idLanguage = t.language')
         
          ->where("n.requestedForEmployee = ".$userid ." AND n.employeeGroup = ".$groupid )
          ->getQuery();
        
        if($results = $query->getArrayResult())
        {
        if($results[0]['idTraining'])
        {
            foreach ($results as $k => $v)
            {
                $results[$k]['totalCost'] = $this->getTotalCost($v['idTraining']);
            }
            return $results;
        }
        }
        
  
    return false;
    }
/* 
 Calcualate training total cost
 @params : 
 * $training_id : training id
 *  */
    public function getTotalCost($training_id)
    {
        $em          = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                ->from('TatweerTrainingBundle:TrainingExpenses', 'tc')
                ->select(" SUM(tc.value) AS totalCost ")->where("tc.training = :training_id ")->setParameter('training_id', $training_id)
                ->getQuery();
                $costResults = $query->getArrayResult();
                return $costResults[0]['totalCost'];
    }
/* 
 Get user training data " requested by HR " 
 @params : 
 * $training_id : training id
 *  */
    public function getUserTrainingById($training_id)
    {
        $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select(" IDENTITY(t.language) AS language ,t.idTraining, t.name, t.providerName, t.startDate, t.endDate, t.duration, c.nameAr AS countryAr , c.nameEn AS countryEn, t.city, t.approvedByHr, t.languageOther, t.createdDate , t.relatedTasks , IDENTITY(t.selfRequestTrainingNeedsId) AS selfRequestTrainingNeedsId "
                  . " , v.valueAr , v.valueEn "
                  . " , IDENTITY(n.requestedForEmployee) AS idUser , IDENTITY(n.employeeGroup) AS idGroup "
                  . " , l.nameAr As langAr , l.nameEn As langEn ")
          ->leftJoin('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 'v.idValue = t.trainingNeedsProgram')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
          ->leftJoin('TatweerTrainingBundle:Countries', 'c', 'WITH', 'c.id = t.country')
          ->leftJoin('TatweerTrainingBundle:Languages', 'l', 'WITH', 'l.idLanguage = t.language')
         
          ->where("t.idTraining = ".$training_id )
          ->getQuery();
        
        $results = $query->getArrayResult();
        return $results[0];
    }
/* 
 Get user Individual training data " self request "
 @params : 
 * $training_id : training id
 *  */
    public function getUserIndividualTrainingById($training_id)
    {
        $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select(" IDENTITY(t.language) AS language ,t.idTraining, t.name, t.providerName, t.startDate, t.endDate, t.duration, c.nameAr AS countryAr , c.nameEn AS countryEn, t.city, t.approvedByHr, t.languageOther, t.createdDate , t.relatedTasks , IDENTITY(t.selfRequestTrainingNeedsId) AS selfRequestTrainingNeedsId "
                 // . " , v.valueAr , v.valueEn "
                  . " , IDENTITY(n.requestedForEmployee) AS idUser , IDENTITY(n.employeeGroup) AS idGroup "
                  . " , l.nameAr As langAr , l.nameEn As langEn ")
          //->leftJoin('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 'v.idValue = t.trainingNeedsProgram')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = t.selfRequestTrainingNeedsId')
          ->leftJoin('TatweerTrainingBundle:Countries', 'c', 'WITH', 'c.id = t.country')
          ->leftJoin('TatweerTrainingBundle:Languages', 'l', 'WITH', 'l.idLanguage = t.language')
         
          ->where("t.idTraining = ".$training_id )
          ->getQuery();
        
        $results = $query->getArrayResult();
        return $results[0];
    }
/* 
 Get user training need data by training data " requested by HR " 
 @params : 
 * $training_id : training id
 *  */
    public function getTrainingNeedByTraining($training_id)
    {
        $em                   = $this->getEntityManager();
        $entity               = $em->getRepository('TatweerTrainingBundle:Trainings')->find($training_id);
        
        if($entity->getTrainingNeedsProgram() && is_null($entity->getSelfRequestTrainingNeedsId()))
        {
        if($trainingNeedsValue= $em->getRepository('TatweerTrainingBundle:TrainingNeedsValues')->find($entity->getTrainingNeedsProgram()))
        {
        $trainingNeeds     = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($trainingNeedsValue->getTrainingNeed());  
        return $trainingNeeds;
        }
        }
        elseif($entity->getSelfRequestTrainingNeedsId() && ! is_null($entity->getSelfRequestTrainingNeedsId()) )
        {
        $trainingNeeds     = $em->getRepository('TatweerTrainingBundle:TrainingNeeds')->find($entity->getSelfRequestTrainingNeedsId());  
        return $trainingNeeds;
        }
        
        return false;
 
    }
/* 
 check if user has training data " requested by HR " 
 @params : 
 * $trainingneed_id : training need id
 *  */
    
    public function hasTrainingDetailes($trainingneed_id)
    {
      $em                   = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select(" t ")
          ->leftJoin('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 'v.idValue = t.trainingNeedsProgram')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
          ->where("n.idNeed = :training_id" )
          ->setParameter("training_id", $trainingneed_id)
          ->getQuery();
        
        if( $query->getArrayResult() )
            return true;
        
        return false;
 
    }
/* 
 Get training Expenses data 
 @params : 
 * $trainingneed_id : training need id
 *  */
    
    public function getTrainingExpenses($trainingneed_id)
    {
      $em                   = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingExpenses', 't')
          ->select(" t.value , c.name ")
          ->leftJoin('TatweerTrainingBundle:TrainingExpensesClasses', 'c', 'WITH', 'c.idClass = t.expenseClass')
          ->where("t.training = :training_id" )
          ->setParameter("training_id", $trainingneed_id)
          ->getQuery();
      
       return $query->getArrayResult();
         
    
 
    }
    
/* 
 Get the Selected training data by employee 
 @params : 
 * $groupid : user group 
 * $userid  : user id
 *  */
    
    public function getSelectedTraining($groupid , $userid)
    {
        $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t")
          ->leftJoin('TatweerTrainingBundle:TrainingNeedsValues', 'v', 'WITH', 'v.idValue = t.trainingNeedsProgram')
          ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
          ->where("n.requestedForEmployee = :userid AND n.employeeGroup = :groupid AND t.chosenByEmployee = 1 " )
          ->setParameter('userid', $userid)->setParameter('groupid', $groupid)
          ->getQuery();
        
        if($results = $query->getArrayResult())
            return $results[0]['idTraining'];
        
        
        return false;

    }
    
/* 
 Return self-training data for an employee 
 @params : 
 * $userid  : user id
 *  */
    
    public function getSelfTrainings($userid)
    {
        $em          = $this->getEntityManager();

        $sql = "
            SELECT `trainings`.id_training AS idTraining ,
            `training_needs_actions_log`.id_action AS canNotCancel ,
            `training_needs_actions_log`.action ,
            `trainings`.modified_by  AS modifiedBy,
            `trainings`.modified_date AS modifiedDate,
            `users`.arabic_fullname  AS arabic_fullname ,
            `users`.english_fullname  AS english_fullname 
           
            FROM `trainings` 
            
            LEFT JOIN ( SELECT MAX(`training_needs_actions_log`.`id_action`) AS actionid , 
            `training_needs_actions_log`.`training_need_id` 
            FROM `training_needs_actions_log`
            Group by `training_needs_actions_log`.`training_need_id` ) AS action 
            ON `trainings`.`self_request_trainingneed_id`  = action.`training_need_id` 
            
            LEFT JOIN `training_needs_actions_log` ON action.actionid = `training_needs_actions_log`.`id_action` 
            LEFT JOIN `users` ON `users`.id_user = `trainings`.modified_by
            
            WHERE `trainings`.created_by = $userid AND `trainings`.self_request_trainingneed_id IS NOT NULL 
                ORDER BY `trainings`.id_training DESC
            ";    
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            $results  = $stmt->fetchAll();  
        
        
     /* $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t.idTraining , t.modifiedDate  , a.idAction AS canNotCancel ")
          ->leftJoin('TatweerTrainingBundle:TrainingNeedsActionsLog', 'a', 'WITH', 'a.trainingNeed = t.selfRequestTrainingNeedsId')
        //  ->leftJoin('TatweerTrainingBundle:TrainingNeeds', 'n', 'WITH', 'n.idNeed = v.trainingNeed')
       //   ->where("n.requestedForEmployee = :userid AND n.employeeGroup = :groupid AND t.chosenByEmployee = 1 " )
          ->where("t.createdBy = :userid AND t.selfRequestTrainingNeedsId IS NOT NULL " )
          ->setParameter('userid', $userid)
          ->getQuery();
        
        if($results = $query->getArrayResult())*/
            return $results;
        
        
        return false;

    }
  
    
    public function findAssignedSelfTraining( $groups , $requested_user_id)
    {
        $em                    = $this->getEntityManager();
        $currentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();

        $sql = "
            SELECT `trainings`.id_training AS idTraining , `trainings`.self_request_trainingneed_id AS selfRequestTrainingNeedsId , `users`.*
            FROM `trainings` 
            
            JOIN ( SELECT MAX(`training_needs_actions_log`.`id_action`) AS actionid , 
            `training_needs_actions_log`.`training_need_id` 
            FROM `training_needs_actions_log`
            Group by `training_needs_actions_log`.`training_need_id` ) AS action 
            ON `trainings`.`self_request_trainingneed_id`  = action.`training_need_id` 
            
            LEFT JOIN `training_needs_actions_log` ON action.actionid = `training_needs_actions_log`.`id_action` 
            LEFT JOIN `training_needs` ON `trainings`.self_request_trainingneed_id = `training_needs`.`id_need` 
            LEFT JOIN `users` ON `users`.id_user = `training_needs`.requested_for_employee
            

            WHERE `training_needs_actions_log`.assigned_to_group IN (". implode(",",$groups) .") 
            AND `trainings`.self_request_trainingneed_id IS NOT NULL  AND `training_needs`.requested_for_employee  IN (". implode(",",$requested_user_id) .")    
            ";    
        
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            if($results  = $stmt->fetchAll())
            {
              //  print_r($results);
               // echo "<br/><br/>";
            return $results;
            }
        return FALSE;
        
        
    }

    
    
    public function followupAssignedSelfTraining( $roles)
    {
        $em                    = $this->getEntityManager();
        $currentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();

        $sql = "
            SELECT `trainings`.id_training AS idTraining , `trainings`.self_request_trainingneed_id AS selfRequestTrainingNeedsId , `users`.*
            FROM `trainings` 
            
            JOIN ( SELECT MAX(`training_needs_actions_log`.`id_action`) AS actionid , 
            `training_needs_actions_log`.`training_need_id` 
            FROM `training_needs_actions_log`
            Group by `training_needs_actions_log`.`training_need_id` ) AS action 
            ON `trainings`.`self_request_trainingneed_id`  = action.`training_need_id` 
            
            LEFT JOIN `training_needs_actions_log` ON action.actionid = `training_needs_actions_log`.`id_action` 
            LEFT JOIN `training_needs` ON `trainings`.self_request_trainingneed_id = `training_needs`.`id_need` 
            LEFT JOIN `users` ON `users`.id_user = `training_needs`.requested_for_employee
            

            WHERE ( `training_needs_actions_log`.assigned_to_role IN (". implode(",",$roles) .") OR `training_needs_actions_log`.assigned_to_training_specialist = ".$currentLoggedInUserId." )
            AND `trainings`.self_request_trainingneed_id IS NOT NULL    
            ";    
        
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            if($results  = $stmt->fetchAll())
            {
              //  print_r($results);
               // echo "<br/><br/>";
            return $results;
            }
        return FALSE;
        
        
    }
    
/* 
 check if is Individual Training or not
 @params : 
 * $trainingneed_id  : trining need id
 *  */
    public function isIndividualTraining($trainingneed_id)
    {
        $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t")
          ->where("t.selfRequestTrainingNeedsId = :trainingneed_id" )
          ->setParameter('trainingneed_id', $trainingneed_id)
          ->getQuery();
        
        if($result = $query->getArrayResult())
            return $result[0]['idTraining'];
        
        
        return false;
    }
/* 
 return employee group id
 @params : 
 * $trainingneed_id  : trining need id
 *  */
    public function getActorGroup($trainingneed_id)      
    {
        $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:TrainingNeedsActionsLog', 't')
          ->select("IDENTITY(t.actorGroup) AS actorGroup")
          ->where("t.actorRole = 5 AND t.actorGroup IS NOT NULL AND t.trainingNeed = :trainingneed_id " )
          ->setParameter('trainingneed_id', $trainingneed_id)
          ->getQuery();
        
        if($result = $query->getArrayResult())
            return $result[0]['actorGroup'];
        
        return false;
    }
    
    // public function getSelfTrainingsRequests( $roles )
   // {
      /*  $em          = $this->getEntityManager();

        $sql = "
            SELECT `trainings`.id_training AS idTraining 
            FROM `trainings` 
            
            JOIN ( SELECT MAX(`training_needs_actions_log`.`id_action`) AS actionid , 
            `training_needs_actions_log`.`training_need_id` 
            FROM `training_needs_actions_log`
            Group by `training_needs_actions_log`.`training_need_id` ) AS action 
            ON `trainings`.`self_request_trainingneed_id`  = action.`training_need_id` 
            
            
            LEFT JOIN `training_needs_actions_log` ON action.actionid = `training_needs_actions_log`.`id_action` 
            LEFT JOIN `users` ON `users`.id_user = `training_needs_actions_log`.`id_action` 
            WHERE `training_needs_actions_log`.assigned_to_group IN () AND `trainings`.self_request_trainingneed_id IS NOT NULL 
           
            ";    
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            $results  = $stmt->fetchAll();  */
   // }

}