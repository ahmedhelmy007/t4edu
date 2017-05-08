<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingNeedsActionsLog
 *
 * @ORM\Table(name="training_needs_actions_log", indexes={@ORM\Index(name="training_needs_actions_log_actorid_fk_idx", columns={"actor_id"}), @ORM\Index(name="training_needs_actions_log_trainingneedid_fk_idx", columns={"training_need_id"}), @ORM\Index(name="forwarded_to_user", columns={"forwarded_to_user"}), @ORM\Index(name="assigned_to_group", columns={"assigned_to_group"}), @ORM\Index(name="assigned_to_role", columns={"assigned_to_role"}), @ORM\Index(name="assigned_to_training_specialist", columns={"assigned_to_training_specialist"}), @ORM\Index(name="actor_role", columns={"actor_role"}), @ORM\Index(name="actor_group", columns={"actor_group"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TrainingNeedsActionsLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_action", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAction;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="actor_comment", type="text", length=65535, nullable=true)
     */
    private $actorComment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actor_group", referencedColumnName="id_group")
     * })
     */
    private $actorGroup;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actor_id", referencedColumnName="id_user")
     * })
     */
    private $actor;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forwarded_to_user", referencedColumnName="id_user")
     * })
     */
    private $forwardedToUser;

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
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="actor_role", referencedColumnName="id_role")
     * })
     */
    private $actorRole;

    /**
     * @var \TrainingNeeds
     *
     * @ORM\ManyToOne(targetEntity="TrainingNeeds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="training_need_id", referencedColumnName="id_need")
     * })
     */
    private $trainingNeed;



    /**
     * Get idAction
     *
     * @return integer 
     */
    public function getIdAction()
    {
        return $this->idAction;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return TrainingNeedsActionsLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set actorComment
     *
     * @param string $actorComment
     * @return TrainingNeedsActionsLog
     */
    public function setActorComment($actorComment)
    {
        $this->actorComment = $actorComment;

        return $this;
    }

    /**
     * Get actorComment
     *
     * @return string 
     */
    public function getActorComment()
    {
        return $this->actorComment;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return TrainingNeedsActionsLog
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
     * Set createdBy
     *
     * @param integer $createdBy
     * @return TrainingNeedsActionsLog
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set actorGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $actorGroup
     * @return TrainingNeedsActionsLog
     */
    public function setActorGroup(\Tatweer\TrainingBundle\Entity\Groups $actorGroup = null)
    {
        $this->actorGroup = $actorGroup;

        return $this;
    }

    /**
     * Get actorGroup
     *
     * @return \Tatweer\TrainingBundle\Entity\Groups 
     */
    public function getActorGroup()
    {
        return $this->actorGroup;
    }

    /**
     * Set actor
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $actor
     * @return TrainingNeedsActionsLog
     */
    public function setActor(\Tatweer\TrainingBundle\Entity\Users $actor = null)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * Get actor
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set forwardedToUser
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $forwardedToUser
     * @return TrainingNeedsActionsLog
     */
    public function setForwardedToUser(\Tatweer\TrainingBundle\Entity\Users $forwardedToUser = null)
    {
        $this->forwardedToUser = $forwardedToUser;

        return $this;
    }

    /**
     * Get forwardedToUser
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getForwardedToUser()
    {
        return $this->forwardedToUser;
    }

    /**
     * Set assignedToGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Groups $assignedToGroup
     * @return TrainingNeedsActionsLog
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
     * @return TrainingNeedsActionsLog
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
     * @return TrainingNeedsActionsLog
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
     * Set actorRole
     *
     * @param \Tatweer\TrainingBundle\Entity\Roles $actorRole
     * @return TrainingNeedsActionsLog
     */
    public function setActorRole(\Tatweer\TrainingBundle\Entity\Roles $actorRole = null)
    {
        $this->actorRole = $actorRole;

        return $this;
    }

    /**
     * Get actorRole
     *
     * @return \Tatweer\TrainingBundle\Entity\Roles 
     */
    public function getActorRole()
    {
        return $this->actorRole;
    }

    /**
     * Set trainingNeed
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingNeeds $trainingNeed
     * @return TrainingNeedsActionsLog
     */
    public function setTrainingNeed(\Tatweer\TrainingBundle\Entity\TrainingNeeds $trainingNeed = null)
    {
        $this->trainingNeed = $trainingNeed;

        return $this;
    }

    /**
     * Get trainingNeed
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingNeeds 
     */
    public function getTrainingNeed()
    {
        return $this->trainingNeed;
    }

            
    /**
    * @ORM\PrePersist
    */
    public function setCreatedDateValue()
    {
        $this->createdDate = new \DateTime();
    }
}
