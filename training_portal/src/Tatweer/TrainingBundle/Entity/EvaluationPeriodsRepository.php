<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EvaluationPeriodsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluationPeriodsRepository extends EntityRepository
{
    /**
     * Find any conflict between the given evaluation period and other evaluation periods
     */
    
    public function findOverlappingWithRange(\DateTime $startDate, \DateTime $endDate, $excludedId)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $expr1 = $queryBuilder->expr()->andX('e.startDate <= :startDate AND e.endDate > :startDate');
        $expr2 = $queryBuilder->expr()->andX('e.startDate < :endDate AND e.endDate >= :endDate');
        $expr3 = $queryBuilder->expr()->andX('e.startDate > :startDate AND e.endDate < :endDate');
        $finalExpr = $queryBuilder->expr()->orX($expr1, $expr2, $expr3);
        
        $queryBuilderwithWhere= $queryBuilder->andWhere($finalExpr)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate);
        
        if($excludedId){
            //if excludedId is set then it is an edit operation, So we should add a condition to exclude current
            //record from searching for overlapping duration
            $finalExpr = $queryBuilder->expr()->andX($finalExpr, 'e.idPeriod != :excludedId');
            $queryBuilderwithWhere= $queryBuilder->andWhere($finalExpr)
                ->setParameter('excludedId', $excludedId)
            ;
        }
        return $queryBuilderwithWhere
            ->getQuery()
            ->execute()
        ;
    }
    
    // get current active period 
    public function hasOpenEvaluationPeriod()
    {
        $query= $this->getEntityManager()->createQuery(
        'SELECT e FROM TatweerTrainingBundle:EvaluationPeriods e 
        WHERE e.startDate <= :today AND e.endDate > :today AND e.active = 1
        ')->setParameter('today', new \DateTime());

        if($result = $query->getArrayResult())
            return $result;
        
        return FALSE;
    }
    
     // get current active period 
    public function hasOpenTrainingNeedsPeriod()
    {
        $query= $this->getEntityManager()->createQuery(
        'SELECT e FROM TatweerTrainingBundle:EvaluationPeriods e 
        WHERE e.trainingNeedsStartDate <= :today AND e.trainingNeedsEndDate > :today AND e.active = 1
        ')->setParameter('today', new \DateTime());

        if($result = $query->getArrayResult())
            return $result;
        
        return FALSE;
    }
    
    // get last // ended period 
    public function getLastEvaluationPeriod()
    {
        $query= $this->getEntityManager()->createQuery(
        'SELECT e FROM TatweerTrainingBundle:EvaluationPeriods e 
        WHERE e.endDate < :today  AND e.active = 1 order by e.endDate DESC  
        ')->setParameter('today', new \DateTime())->setMaxResults(1);

        if($result = $query->getArrayResult())
            return $result;
        
        return FALSE;
    }
    
    // get last // ended period 
    public function getLastTrainingNeedsPeriod()
    {
        $query= $this->getEntityManager()->createQuery(
        'SELECT e FROM TatweerTrainingBundle:EvaluationPeriods e 
        WHERE e.trainingNeedsEndDate < :today  AND e.active = 1 order by e.trainingNeedsEndDate DESC  
        ')->setParameter('today', new \DateTime())->setMaxResults(1);

        if($result = $query->getArrayResult())
            return $result;
        
        return FALSE;
    }
}
