<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TrainingExpensesClassesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BudgetsRepository extends EntityRepository
{
    public function findIfUniqueName(array $data)
    {
        if($data['idBudget'] != NULL )
        {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM TatweerTrainingBundle:Budgets p WHERE p.name = '".$data['name']."'  AND p.idBudget <> ".$data['idBudget']."  AND p.deleted = 0"
            )
            ->getResult();
        }
         else {
             return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM TatweerTrainingBundle:Budgets p WHERE p.name = '".$data['name']."'   AND p.deleted = 0"
            )
            ->getResult();
             }
        
    }
    
  
}



