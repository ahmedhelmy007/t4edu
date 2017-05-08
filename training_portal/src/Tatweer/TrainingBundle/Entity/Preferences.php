<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Preferences
 *
 * @ORM\Table(name="preferences")
 * @ORM\Entity
 */
class Preferences
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_preferences", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPreferences;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluation_duration", type="string", length=100, nullable=false)
     */
    private $evaluationDuration;

 


    /**
     * Get idPreferences
     *
     * @return integer 
     */
    public function getIdPreferences()
    {
        return $this->idPreferences;
    }

    /**
     * Set evaluationDuration
     *
     * @param string $evaluationDuration
     * @return Preferences
     */
    public function setEvaluationDuration($evaluationDuration)
    {
        $this->evaluationDuration = $evaluationDuration;

        return $this;
    }

    /**
     * Get evaluationDuration
     *
     * @return string 
     */
    public function getEvaluationDuration()
    {
        return $this->evaluationDuration;
    }

}
