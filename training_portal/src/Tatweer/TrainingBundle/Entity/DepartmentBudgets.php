<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DepartmentBudgets
 *
 * @ORM\Table(name="department_budgets", uniqueConstraints={@ORM\UniqueConstraint(name="budget_id", columns={"budget_id", "department_id"})}, indexes={@ORM\Index(name="department_budgets_budgetid_fk_idx", columns={"budget_id"}), @ORM\Index(name="department_budgets_createdby_idx", columns={"created_by"}), @ORM\Index(name="department_budgets_modifiedby_fk_idx", columns={"modified_by"}), @ORM\Index(name="department_budgets_deptid_fk_idx", columns={"department_id"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\DepartmentBudgetsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class DepartmentBudgets
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_dept_budget", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDeptBudget;

    /**
     * @var integer
     *
     * @ORM\Column(name="original_value", type="integer", nullable=true)
     */
    private $originalValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="remaining_value", type="integer", nullable=true)
     */
    private $remainingValue;

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
     *   @ORM\JoinColumn(name="modified_by", referencedColumnName="id_user")
     * })
     */
    private $modifiedBy;

    /**
     * @var \Budgets
     *
     * @ORM\ManyToOne(targetEntity="Budgets", inversedBy="budgetDepartments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="budget_id", referencedColumnName="id_budget" )
     * })
     */
    private $budget;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Departments", inversedBy="budgetDepartments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department_id", referencedColumnName="id_group")
     * })
     */
    private $department;


    /**
     * Get getId
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idDeptBudget;
    }

    /**
     * Get idDeptBudget
     *
     * @return integer 
     */
    public function getIdDeptBudget()
    {
        return $this->idDeptBudget;
    }

    /**
     * Set originalValue
     *
     * @param integer $originalValue
     * @return DepartmentBudgets
     */
    public function setOriginalValue($originalValue)
    {
        $this->originalValue = $originalValue;

        return $this;
    }

    /**
     * Get originalValue
     *
     * @return integer 
     */
    public function getOriginalValue()
    {
        return $this->originalValue;
    }

    /**
     * Set remainingValue
     *
     * @param integer $remainingValue
     * @return DepartmentBudgets
     */
    public function setRemainingValue($remainingValue)
    {
        $this->remainingValue = $remainingValue;

        return $this;
    }

    /**
     * Get remainingValue
     *
     * @return integer 
     */
    public function getRemainingValue()
    {
        return $this->remainingValue;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return DepartmentBudgets
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
     * @return DepartmentBudgets
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
     * Set budget
     *
     * @param \Tatweer\TrainingBundle\Entity\Budgets $budget
     * @return DepartmentBudgets
     */
    public function setBudget(\Tatweer\TrainingBundle\Entity\Budgets $budget = null)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return \Tatweer\TrainingBundle\Entity\Budgets 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set createdBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return DepartmentBudgets
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
     * Set department
     *
     * @param \Tatweer\TrainingBundle\Entity\Departments $department
     * @return DepartmentBudgets
     */
    public function setDepartment(\Tatweer\TrainingBundle\Entity\Departments $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \Tatweer\TrainingBundle\Entity\Departments 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set modifiedBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $modifiedBy
     * @return DepartmentBudgets
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
