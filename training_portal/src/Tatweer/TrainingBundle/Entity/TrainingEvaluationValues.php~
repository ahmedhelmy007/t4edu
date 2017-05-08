<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingEvaluationValues
 *
 * @ORM\Table(name="training_evaluation_values", indexes={@ORM\Index(name="training_evaluations_evaluationid_fk_idx", columns={"evaluation_id"}), @ORM\Index(name="training_evaluations_criteriaid_fk_idx", columns={"criteria_id"}), @ORM\Index(name="training_evaluations_selectedoptionid_fk_idx", columns={"selected_option_id"})})
 * @ORM\Entity
 */
class TrainingEvaluationValues
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_value", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idValue;

    /**
     * @var \TrainingEvaluationCriterias
     *
     * @ORM\ManyToOne(targetEntity="TrainingEvaluationCriterias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="criteria_id", referencedColumnName="id_criteria")
     * })
     */
    private $criteria;

    /**
     * @var \TrainingEvaluations
     *
     * @ORM\ManyToOne(targetEntity="TrainingEvaluations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evaluation_id", referencedColumnName="id_evaluation")
     * })
     */
    private $evaluation;

    /**
     * @var \TrainingEvaluationOptions
     *
     * @ORM\ManyToOne(targetEntity="TrainingEvaluationOptions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="selected_option_id", referencedColumnName="id_option")
     * })
     */
    private $selectedOption;



    /**
     * Get idValue
     *
     * @return integer 
     */
    public function getIdValue()
    {
        return $this->idValue;
    }

    /**
     * Set criteria
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingEvaluationCriterias $criteria
     * @return TrainingEvaluationValues
     */
    public function setCriteria(\Tatweer\TrainingBundle\Entity\TrainingEvaluationCriterias $criteria = null)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * Get criteria
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingEvaluationCriterias 
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set evaluation
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingEvaluations $evaluation
     * @return TrainingEvaluationValues
     */
    public function setEvaluation(\Tatweer\TrainingBundle\Entity\TrainingEvaluations $evaluation = null)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingEvaluations 
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set selectedOption
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingEvaluationOptions $selectedOption
     * @return TrainingEvaluationValues
     */
    public function setSelectedOption(\Tatweer\TrainingBundle\Entity\TrainingEvaluationOptions $selectedOption = null)
    {
        $this->selectedOption = $selectedOption;

        return $this;
    }

    /**
     * Get selectedOption
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingEvaluationOptions 
     */
    public function getSelectedOption()
    {
        return $this->selectedOption;
    }
}
