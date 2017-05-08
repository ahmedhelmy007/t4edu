<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EmployeesEvaluationsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmployeesEvaluationsRepository extends EntityRepository
{
    
    public function buildForm($evaluationID = null )
    {
    
        $em          = $this->getEntityManager();
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:EmployeesEvaluationSections', 's')
          ->select("s")
          ->where("s.active = 1")
          ->addOrderBy("s.idSection", "ASC")
          ->getQuery();
        $form['sectionResult'] = $query->getArrayResult();
        
        if(!is_null($evaluationID))
        {
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:EmployeesEvaluationCriterias', 'c')
          ->select("c.idCriteria , IDENTITY(c.section) AS section , c.nameAr , c.nameEn , IDENTITY(v.selectedOption) AS selectedOption , v.idValue AS idValue ")
          ->leftJoin('TatweerTrainingBundle:EmployeesEvaluationValues', 'v', 'WITH', 'v.criteria = c.idCriteria')
          ->where("c.active = 1 AND v.evaluation = ".$evaluationID)
          ->addOrderBy("c.section , c.idCriteria", "ASC")
          ->getQuery();
        }
        else 
        {
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:EmployeesEvaluationCriterias', 'c')
          ->select("c.idCriteria , IDENTITY(c.section) AS section , c.nameAr , c.nameEn")
          ->where("c.active = 1")
          ->addOrderBy("c.section , c.idCriteria", "ASC")
          ->getQuery();
        }
        $form['criteriasResult'] = $query->getArrayResult();
        
         $query = $em->createQueryBuilder()
          ->from('TatweerTrainingBundle:EmployeesEvaluationOptions', 'o')
          ->select("o.idOption , IDENTITY(o.section) AS section , o.nameAr , o.nameEn")
          ->where("o.active = 1")
          ->addOrderBy("o.idOption ", "DESC")
          ->getQuery();
        $form['optionsResult'] = $query->getArrayResult();
        
        return $form;
    }
    
    public function getPerformancePotentialsIntersect($evaluationID)
    {
        $em          = $this->getEntityManager();
        $Performance = array(
            'Low'=>array(7,8,9) , 
            'Average'=>array(4,5,6) , 
            'High' =>array(1,2,3)
        );
        
        $Potentials  = array(
            'Low'=>array(7,4,1) , 
            'Average'=>array(8,5,2) , 
            'High' =>array(9,6,3)
        );
        

        if($evaluationID)
        {
          
           $query = $em->createQueryBuilder()
      
          ->from('TatweerTrainingBundle:EmployeesEvaluationOptions', 'o')
          ->select("COUNT(v.selectedOption) AS total , IDENTITY(o.section) AS section ")
          ->leftJoin('TatweerTrainingBundle:EmployeesEvaluationValues', 'v', 'WITH', 'v.selectedOption = o.idOption')
          ->where("o.nameEn = 'Yes' AND v.evaluation = ".$evaluationID)
          ->groupBy('o.section')
          ->getQuery();
           $result = $query->getArrayResult();
           
           foreach ($result as $k => $v)
           {
               if($v['section'] == 1 )
               $PerformanceTotal = $v['total'];
               elseif($v['section'] == 2 )
               $PotentialsTotal  = $v['total'];
           }
           
           
           switch ($PerformanceTotal)
           {
              case 0: case 1: case 2: $PerformanceResult = 'Low';     break;
              case 3: case 4:         $PerformanceResult = 'Average'; break;
              case 5: case 6:         $PerformanceResult = 'High';    break;
           }
            
           switch ($PotentialsTotal)
           {
              case 0: case 1: case 2:  case 3:  $PotentialsResult = 'Low';     break;
              case 4: case 5: case 6:  case 7:  $PotentialsResult = 'Average'; break;
              case 8: case 9: case 10: case 11: $PotentialsResult = 'High';    break;
           }
              
           if(isset($PerformanceResult) && isset($PotentialsResult))
           {
           $result = array_intersect($Performance[$PerformanceResult], $Potentials[$PotentialsResult]);
           return current($result);
           }
        }
        return null;
    }
}
