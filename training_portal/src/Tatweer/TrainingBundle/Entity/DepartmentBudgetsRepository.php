<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrainingsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepartmentBudgetsRepository extends EntityRepository
{
    
    
    
    public function getDepartmentBudget($departmentId )
    {
      $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:DepartmentBudgets', 'd')
          ->select("d.idDeptBudget , d.originalValue , d.remainingValue  ,  b.name ")
          ->leftJoin('TatweerTrainingBundle:Budgets', 'b', 'WITH', 'b.idBudget = d.budget')
          ->where("b.deleted = 0 AND b.active = 1 AND  d.department = :department_id" )
          ->setParameter('department_id', $departmentId)
          ->getQuery();
        
        $results = $query->getArrayResult();
       // echo "<pre>";
       // print_r($results);
       // echo "</pre>";
        return $results;
    }
    
     
    
    public function deductedTrainingRequests($budget_id)
    {
      $em          = $this->getEntityManager();

      $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:Trainings', 't')
          ->select("t")
          ->leftJoin('TatweerTrainingBundle:DepartmentBudgets', 'd', 'WITH', 'd.idDeptBudget = t.departmentBudget')
          ->leftJoin('TatweerTrainingBundle:Budgets', 'b', 'WITH', 'b.idBudget = d.budget')
          ->where("b.idBudget = :budget_id" )
          ->setParameter('budget_id', $budget_id)
          ->getQuery();
        
        if($query->getArrayResult())
        return true;
        else 
            return false;
    }
    
    
    public function getAllDepartmentAndBudgets($budget_id )
    {
        $em          = $this->getEntityManager();
        $counter     = 0;
        $departments = $em->getRepository('TatweerTrainingBundle:Departments')->findBy( array('deleted' => 0 , 'parent' => NULL) );
        foreach ($departments as $department) 
        {
       
            //d.name , d.idGroup , 
        $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:DepartmentBudgets', 'db')
          ->select("db.idDeptBudget , db.originalValue ")
          ->where("db.department = :department_id AND db.budget = :budget_id" )
          ->setParameter('department_id', $department->getIdGroup())
          ->setParameter('budget_id', $budget_id)
          ->getQuery();
        if($subresults = $query->getArrayResult())
        $results[$counter]['originalValue'] = $subresults[0]['originalValue'];
        else
        $results[$counter]['originalValue'] = '';
        $results[$counter]['name']          = $department->getName();
        $results[$counter]['idGroup']       = $department->getIdGroup();
        $results[$counter]['idBudget']      = $budget_id;
        
        $counter++; 
        
        }
        

        return $results;
    }
    
    
    public function canUpdateDepartmentBudget($id , $department_id , $value)
    {
        $em          = $this->getEntityManager();
        if( $departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->findBy(array( 'budget'=> $id , 'department'=>$department_id ) ))
        {
            //return $departmentBudget[0]->getRemainingValue();
            $originalValue  = $departmentBudget[0]->getOriginalValue();
            $remainingValue = $departmentBudget[0]->getRemainingValue();
            if( $remainingValue == $value )
                 return 1;
            elseif( ($originalValue - $remainingValue)  > $value )
                 return 0; 
            else 
                 return 1;
        }
        return 1;
        
    }
}
