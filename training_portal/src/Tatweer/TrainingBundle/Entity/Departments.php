<?php

namespace Tatweer\TrainingBundle\Entity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Departments
 *
 * @ORM\Table(name="groups", indexes={@ORM\Index(name="groups_createddby_idx", columns={"created_by"}), @ORM\Index(name="groups_parent_idx", columns={"parent_id"}), @ORM\Index(name="groups_modifiedby_idx", columns={"modified_by"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\DepartmentsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Departments 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_group", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroup;

    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

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
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id_group")
     * })
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="Budgets", mappedBy="departments")
     * used for insert multiple Rentalperiods as ManyToMany
     */
    protected $budgets;

    /**
     * @ORM\OneToMany(targetEntity="DepartmentBudgets", mappedBy="department", cascade={"persist"})
     * used for insert multiple Departments with original_value
     */
    private $budgetDepartments;


    /**
     * Get getId
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idGroup;
    }

    /**
     * Get idGroup
     *
     * @return integer 
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }
    

    /**
     * Set name
     *
     * @param string $name
     * @return Departments
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
     * Set description
     *
     * @param string $description
     * @return Departments
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Departments
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
     * @return Departments
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return Departments
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
     * Set createdBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return Departments
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
     * Set modifiedBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $modifiedBy
     * @return Departments
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
     * Set parent
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $parent
     * @return Departments
     */
    public function setParent(\Tatweer\TrainingBundle\Entity\Groups $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Tatweer\TrainingBundle\Entity\Groups 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Override PHP magic function __toString() to return the current object field "name"
     */
    public function __toString(){
        return (string)$this->getName();
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
    
    /**
    * @ORM\PrePersist
    */
    public function setDeletedValue()
    {
        $this->deleted = 0;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->budgets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->budgetDepartments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add budgets
     *
     * @param \Tatweer\TrainingBundle\Entity\Budgets $budgets
     * @return Departments
     */
    public function addBudget(\Tatweer\TrainingBundle\Entity\Budgets $budgets)
    {
        $this->budgets[] = $budgets;

        return $this;
    }

    /**
     * Remove budgets
     *
     * @param \Tatweer\TrainingBundle\Entity\Budgets $budgets
     */
    public function removeBudget(\Tatweer\TrainingBundle\Entity\Budgets $budgets)
    {
        $this->budgets->removeElement($budgets);
    }

    /**
     * Get budgets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBudgets()
    {
        return $this->budgets;
    }

    /**
     * Add budgetDepartments
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $budgetDepartments
     * @return Departments
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
     * Get budgetDepartments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBudgetDepartments()
    {
        return $this->budgetDepartments;
    }
}
