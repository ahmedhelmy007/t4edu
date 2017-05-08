<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeesEvaluationValues
 *
 * @ORM\Table(name="employees_evaluation_values", indexes={@ORM\Index(name="employees_evaluations_evaluationid_fk_idx", columns={"evaluation_id"}), @ORM\Index(name="employees_evaluations_criteriaid_fk_idx", columns={"criteria_id"}), @ORM\Index(name="employees_evaluations_selectedoptionid_fk_idx", columns={"selected_option_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EmployeesEvaluationValues
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
     * @var \EmployeesEvaluationCriterias
     *
     * @ORM\ManyToOne(targetEntity="EmployeesEvaluationCriterias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="criteria_id", referencedColumnName="id_criteria")
     * })
     */
    private $criteria;

    /**
     * @var \EmployeesEvaluations
     *
     * @ORM\ManyToOne(targetEntity="EmployeesEvaluations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evaluation_id", referencedColumnName="id_evaluation")
     * })
     */
    private $evaluation;

    /**
     * @var \EmployeesEvaluationOptions
     *
     * @ORM\ManyToOne(targetEntity="EmployeesEvaluationOptions")
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
     * @param \Tatweer\TrainingBundle\Entity\EmployeesEvaluationCriterias $criteria
     * @return EmployeesEvaluationValues
     */
    public function setCriteria(\Tatweer\TrainingBundle\Entity\EmployeesEvaluationCriterias $criteria = null)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * Get criteria
     *
     * @return \Tatweer\TrainingBundle\Entity\EmployeesEvaluationCriterias 
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set evaluation
     *
     * @param \Tatweer\TrainingBundle\Entity\EmployeesEvaluations $evaluation
     * @return EmployeesEvaluationValues
     */
    public function setEvaluation(\Tatweer\TrainingBundle\Entity\EmployeesEvaluations $evaluation = null)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return \Tatweer\TrainingBundle\Entity\EmployeesEvaluations 
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set selectedOption
     *
     * @param \Tatweer\TrainingBundle\Entity\EmployeesEvaluationOptions $selectedOption
     * @return EmployeesEvaluationValues
     */
    public function setSelectedOption(\Tatweer\TrainingBundle\Entity\EmployeesEvaluationOptions $selectedOption = null)
    {
        $this->selectedOption = $selectedOption;

        return $this;
    }

    /**
     * Get selectedOption
     *
     * @return \Tatweer\TrainingBundle\Entity\EmployeesEvaluationOptions 
     */
    public function getSelectedOption()
    {
        return $this->selectedOption;
    }
}
