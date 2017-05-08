<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Budgets
 *
 * @ORM\Table(name="budgets")
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\BudgetsRepository")
 */
class Budgets
{
    /**
     * @var smallint
     *
     * @ORM\Column(name="id_budget", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBudget;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var \Date
     *
     * @ORM\Column(name="start_date", type="string", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="string", nullable=true)
     */
    private $endDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted =0;

    /**
     * @ORM\ManyToMany(targetEntity="Departments", inversedBy="budgets")
     * @ORM\JoinTable(name="department_budgets",
     * joinColumns={@ORM\JoinColumn(name="budget_id", referencedColumnName="id_budget")}, 
     * inverseJoinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="id_group")})
     * used for insert multiple Departments as ManyToMany
     */
    protected $departments;

    /**
     * @ORM\OneToMany(targetEntity="DepartmentBudgets", mappedBy="budget", cascade={"persist"})
     * used for insert multiple Departments with original_value
     */
    private $budgetDepartments;
    
    /**
     * @ORM\OneToMany(targetEntity="DepartmentBudgets", mappedBy="budget", cascade={"remove"})
     * used for delete multiple Departments
     */
    private $budgetDepartments2;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departmentBudgets = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return boolean 
     */
    public function getId()
    {
        return $this->idBudget;
    }

    /**
     * Get idBudget
     *
     * @return boolean 
     */
    public function getIdBudget()
    {
        return $this->idBudget;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Budgets
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Budgets
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Budgets
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * Set active
     *
     * @param boolean $active
     * @return TrainingExpensesClasses
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Budgets
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Get Departments
     *
     * @return boolean 
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * Set Departments
     *
     * @return boolean 
     */
    public function setDepartments(Departments $department)
    {
        $this->departments[] = $department;
    }

    /**
     * Get Departments Budgets
     *
     * @return boolean 
     */
    public function getBudgetDepartments()
    {
        return $this->budgetDepartments;
    }

    /**
     * Set Departments Budgets
     *
     * @return boolean 
     */
    public function setBudgetDepartments(Departments $budgetsDepartment)
    {
        $this->budgetDepartments[] = $budgetsDepartment;
    }

    /**
     * Get Departments Budgets 2
     *
     * @return boolean 
     */
    public function getBudgetDepartments2()
    {
        return $this->BudgetDepartments2;
    }

    /**
     * Set Departments Budgets 2
     *
     * @return boolean 
     */
    public function setBudgetDepartments2(Departments $budgetDepartments)
    {
        $this->budgetDepartments2[] = $budgetDepartments;
    }
    
    /**
     * Override PHP magic function __toString() to return the current object field "name"
     */
    public function __toString(){
        return (string)$this->getName();
    }

    /**
     * Add departments
     *
     * @param \Tatweer\TrainingBundle\Entity\Departments $departments
     * @return Budgets
     */
    public function addDepartment(\Tatweer\TrainingBundle\Entity\Departments $departments)
    {
        $this->departments[] = $departments;

        return $this;
    }

    /**
     * Remove departments
     *
     * @param \Tatweer\TrainingBundle\Entity\Departments $departments
     */
    public function removeDepartment(\Tatweer\TrainingBundle\Entity\Departments $departments)
    {
        $this->departments->removeElement($departments);
    }

    /**
     * Add budgetDepartments
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments
     * @return Budgets
     */
    public function addBudgetDepartment(\Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments)
    {
        $this->budgetDepartments[] = $budgetDepartments;

        return $this;
    }

    /**
     * Remove budgetDepartments
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments
     */
    public function removeBudgetDepartment(\Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments)
    {
        $this->budgetDepartments->removeElement($budgetDepartments);
    }

    /**
     * Add budgetDepartments2
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments2
     * @return Budgets
     */
    public function addBudgetDepartments2(\Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments2)
    {
        $this->budgetDepartments2[] = $budgetDepartments2;

        return $this;
    }

    /**
     * Remove budgetDepartments2
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments2
     */
    public function removeBudgetDepartments2(\Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments2)
    {
        $this->budgetDepartments2->removeElement($budgetDepartments2);
    }
}
