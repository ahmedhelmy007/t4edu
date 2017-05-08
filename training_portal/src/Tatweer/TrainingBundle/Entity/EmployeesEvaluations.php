<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeesEvaluations
 *
 * @ORM\Table(name="employees_evaluations", indexes={@ORM\Index(name="employees_evaluations_employeeid_fk_idx", columns={"employee_id"}), @ORM\Index(name="employees_evaluations_evalperiodid_fk_idx", columns={"evaluation_period_id"}), @ORM\Index(name="employees_evaluations_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="employees_evaluations_modifiedby_fk_idx", columns={"modified_by"}), @ORM\Index(name="employees_evaluations_groupid_fk_idx", columns={"group_id"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\EmployeesEvaluationsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class EmployeesEvaluations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_evaluation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvaluation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id_user")
     * })
     */
    private $createdBy;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id", referencedColumnName="id_user")
     * })
     */
    private $employee;

    /**
     * @var \EvaluationPeriods
     *
     * @ORM\ManyToOne(targetEntity="EvaluationPeriods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evaluation_period_id", referencedColumnName="id_period")
     * })
     */
    private $evaluationPeriod;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id_group")
     * })
     */
    private $group;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modified_by", referencedColumnName="id_user")
     * })
     */
    private $modifiedBy;



    /**
     * Get idEvaluation
     *
     * @return integer 
     */
    public function getIdEvaluation()
    {
        return $this->idEvaluation;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return EmployeesEvaluations
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return EmployeesEvaluations
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set createdBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return EmployeesEvaluations
     */
    public function setCreatedBy(\Tatweer\TrainingBundle\Entity\Users $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set employee
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $employee
     * @return EmployeesEvaluations
     */
    public function setEmployee(\Tatweer\TrainingBundle\Entity\Users $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set evaluationPeriod
     *
     * @param \Tatweer\TrainingBundle\Entity\EvaluationPeriods $evaluationPeriod
     * @return EmployeesEvaluations
     */
    public function setEvaluationPeriod(\Tatweer\TrainingBundle\Entity\EvaluationPeriods $evaluationPeriod = null)
    {
        $this->evaluationPeriod = $evaluationPeriod;

        return $this;
    }

    /**
     * Get evaluationPeriod
     *
     * @return \Tatweer\TrainingBundle\Entity\EvaluationPeriods 
     */
    public function getEvaluationPeriod()
    {
        return $this->evaluationPeriod;
    }

    /**
     * Set group
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $group
     * @return EmployeesEvaluations
     */
    public function setGroup(\Tatweer\TrainingBundle\Entity\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Tatweer\TrainingBundle\Entity\Groups 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set modifiedBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $modifiedBy
     * @return EmployeesEvaluations
     */
    public function setModifiedBy(\Tatweer\TrainingBundle\Entity\Users $modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    
        
    /**
    * @ORM\PrePersist
    */
    public function setCreatedDateValue()
    {
        $this->createdDate = new \DateTime();
    }
    
    /**
    * @ORM\preUpdate
    */
    public function setModifiedDateValue()
    {
        $this->modifiedDate = new \DateTime();
    }
    
    
    
}
