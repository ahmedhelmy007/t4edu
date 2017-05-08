<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingNeeds
 *
 * @ORM\Table(name="training_needs", indexes={@ORM\Index(name="training_needs_employeeid_fk_idx", columns={"requested_for_employee"}), @ORM\Index(name="training_needs_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="training_needs_modifiedby_fk_idx", columns={"modified_by"}), @ORM\Index(name="training_needs_assignedtogroup_fk_idx", columns={"assigned_to_group"}), @ORM\Index(name="training_needs_assignedtorole_fk_idx", columns={"assigned_to_role"}), @ORM\Index(name="training_needs_assignedtotrsp_fk_idx", columns={"assigned_to_training_specialist"}), @ORM\Index(name="training_needs_groupid_fk_idx", columns={"employee_group_id"}), @ORM\Index(name="trainingneed_period_id", columns={"trainingneed_period_id"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\TrainingNeedsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TrainingNeedsx
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_need", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNeed;

    /**
     * @var string
     *
     * @ORM\Column(name="employee_notes", type="text", length=65535, nullable=true)
     */
    private $employeeNotes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_finally_approved", type="boolean", nullable=true)
     */
    private $isFinallyApproved;

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
     * @var \EvaluationPeriods
     *
     * @ORM\ManyToOne(targetEntity="EvaluationPeriods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trainingneed_period_id", referencedColumnName="id_period")
     * })
     */
    private $trainingneedPeriod;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assigned_to_group", referencedColumnName="id_group")
     * })
     */
    private $assignedToGroup;

    /**
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assigned_to_role", referencedColumnName="id_role")
     * })
     */
    private $assignedToRole;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assigned_to_training_specialist", referencedColumnName="id_user")
     * })
     */
    private $assignedToTrainingSpecialist;

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
     *   @ORM\JoinColumn(name="requested_for_employee", referencedColumnName="id_user")
     * })
     */
    private $requestedForEmployee;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_group_id", referencedColumnName="id_group")
     * })
     */
    private $employeeGroup;

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
     * Get idNeed
     *
     * @return integer 
     */
    public function getIdNeed()
    {
        return $this->idNeed;
    }

    /**
     * Set employeeNotes
     *
     * @param string $employeeNotes
     * @return TrainingNeeds
     */
    public function setEmployeeNotes($employeeNotes)
    {
        $this->employeeNotes = $employeeNotes;

        return $this;
    }

    /**
     * Get employeeNotes
     *
     * @return string 
     */
    public function getEmployeeNotes()
    {
        return $this->employeeNotes;
    }

    /**
     * Set isFinallyApproved
     *
     * @param boolean $isFinallyApproved
     * @return TrainingNeeds
     */
    public function setIsFinallyApproved($isFinallyApproved)
    {
        $this->isFinallyApproved = $isFinallyApproved;

        return $this;
    }

    /**
     * Get isFinallyApproved
     *
     * @return boolean 
     */
    public function getIsFinallyApproved()
    {
        return $this->isFinallyApproved;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return TrainingNeeds
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
     * @return TrainingNeeds
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
     * Set trainingneedPeriod
     *
     * @param \Tatweer\TrainingBundle\Entity\EvaluationPeriods $trainingneedPeriod
     * @return TrainingNeeds
     */
    public function setTrainingneedPeriod(\Tatweer\TrainingBundle\Entity\EvaluationPeriods $trainingneedPeriod = null)
    {
        $this->trainingneedPeriod = $trainingneedPeriod;

        return $this;
    }

    /**
     * Get trainingneedPeriod
     *
     * @return \Tatweer\TrainingBundle\Entity\EvaluationPeriods 
     */
    public function getTrainingneedPeriod()
    {
        return $this->trainingneedPeriod;
    }

    /**
     * Set assignedToGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $assignedToGroup
     * @return TrainingNeeds
     */
    public function setAssignedToGroup(\Tatweer\TrainingBundle\Entity\Groups $assignedToGroup = null)
    {
        $this->assignedToGroup = $assignedToGroup;

        return $this;
    }

    /**
     * Get assignedToGroup
     *
     * @return \Tatweer\TrainingBundle\Entity\Groups 
     */
    public function getAssignedToGroup()
    {
        return $this->assignedToGroup;
    }

    /**
     * Set assignedToRole
     *
     * @param \Tatweer\TrainingBundle\Entity\Roles $assignedToRole
     * @return TrainingNeeds
     */
    public function setAssignedToRole(\Tatweer\TrainingBundle\Entity\Roles $assignedToRole = null)
    {
        $this->assignedToRole = $assignedToRole;

        return $this;
    }

    /**
     * Get assignedToRole
     *
     * @return \Tatweer\TrainingBundle\Entity\Roles 
     */
    public function getAssignedToRole()
    {
        return $this->assignedToRole;
    }

    /**
     * Set assignedToTrainingSpecialist
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $assignedToTrainingSpecialist
     * @return TrainingNeeds
     */
    public function setAssignedToTrainingSpecialist(\Tatweer\TrainingBundle\Entity\Users $assignedToTrainingSpecialist = null)
    {
        $this->assignedToTrainingSpecialist = $assignedToTrainingSpecialist;

        return $this;
    }

    /**
     * Get assignedToTrainingSpecialist
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getAssignedToTrainingSpecialist()
    {
        return $this->assignedToTrainingSpecialist;
    }

    /**
     * Set createdBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return TrainingNeeds
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
     * Set requestedForEmployee
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $requestedForEmployee
     * @return TrainingNeeds
     */
    public function setRequestedForEmployee(\Tatweer\TrainingBundle\Entity\Users $requestedForEmployee = null)
    {
        $this->requestedForEmployee = $requestedForEmployee;

        return $this;
    }

    /**
     * Get requestedForEmployee
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getRequestedForEmployee()
    {
        return $this->requestedForEmployee;
    }

    /**
     * Set employeeGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $employeeGroup
     * @return TrainingNeeds
     */
    public function setEmployeeGroup(\Tatweer\TrainingBundle\Entity\Groups $employeeGroup = null)
    {
        $this->employeeGroup = $employeeGroup;

        return $this;
    }

    /**
     * Get employeeGroup
     *
     * @return \Tatweer\TrainingBundle\Entity\Groups 
     */
    public function getEmployeeGroup()
    {
        return $this->employeeGroup;
    }

    /**
     * Set modifiedBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $modifiedBy
     * @return TrainingNeeds
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
