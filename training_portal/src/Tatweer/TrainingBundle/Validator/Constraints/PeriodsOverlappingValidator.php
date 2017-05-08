<?php

namespace Tatweer\TrainingBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class PeriodsOverlappingValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    

    public function validate($object, Constraint $constraint)
    {
        //die('validating started');
        $conflicts = $this->em
            ->getRepository('TatweerTrainingBundle:EvaluationPeriods')
            ->findOverlappingWithRange( new \DateTime($object->getStartDate()), new \DateTime($object->getEndDate() ), $object->getId() )
        ;

        if (count($conflicts) > 0) {
            //$this->context->addViolationAt('startDate', $constraint->message);
            $this->context->addViolation($constraint->message);
        }
    }
}