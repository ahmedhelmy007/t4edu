<?php

namespace Tatweer\TrainingBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PeriodsOverlapping extends Constraint
{
    public $message = 'The field "%string%" has invalid value.';
    
    // in the base Symfony\Component\Validator\Constraint class
    public function validatedBy()
    {
        return 'periods_overlapping';
    }
    
    /**
     * method defines whether this constraint can be applied to an entire class, a property, or both. 
     * 
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
}