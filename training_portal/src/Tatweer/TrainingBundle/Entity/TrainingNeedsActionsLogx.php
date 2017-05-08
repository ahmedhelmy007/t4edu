<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingNeedsActionsLog
 *
 * @ORM\Table(name="training_needs_actions_log", indexes={@ORM\Index(name="training_needs_actions_log_actorid_fk_idx", columns={"actor_id"}), @ORM\Index(name="training_needs_actions_log_trainingneedid_fk_idx", columns={"training_need_id"}), @ORM\Index(name="forwarded_to_user", columns={"forwarded_to_user"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TrainingNeedsActionsLogx
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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forwarded_to_user", referencedColumnName="id_user")
     * })
     */
    private $forwardedToUser;

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
