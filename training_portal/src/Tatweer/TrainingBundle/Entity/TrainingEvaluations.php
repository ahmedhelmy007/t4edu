<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingEvaluations
 *
 * @ORM\Table(name="training_evaluations", indexes={@ORM\Index(name="training_evaluations_trainingid_fk_idx", columns={"training_id"}), @ORM\Index(name="training_evaluations_traineeid_fk_idx", columns={"trainee_id"}), @ORM\Index(name="training_evaluations_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="training_evaluations_modifiedby_fk_idx", columns={"modified_by"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\TrainingEvaluationsRepository")
 * @ORM\HasLifecycleCallbacks
 */

class TrainingEvaluations
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
     * @var string
     *
     * @ORM\Column(name="trainee_comment", type="text", nullable=true)
     */
    private $traineeComment;

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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trainee_id", referencedColumnName="id_user")
     * })
     */
    private $trainee;

    /**
     * @var \Trainings
     *
     * @ORM\ManyToOne(targetEntity="Trainings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="training_id", referencedColumnName="id_training")
     * })
     */
    private $training;



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
     * Set traineeComment
     *
     * @param string $traineeComment
     * @return TrainingEvaluations
     */
    public function setTraineeComment($traineeComment)
    {
        $this->traineeComment = $traineeComment;

        return $this;
    }

    /**
     * Get traineeComment
     *
     * @return string 
     */
    public function getTraineeComment()
    {
        return $this->traineeComment;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return TrainingEvaluations
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
     * @return TrainingEvaluations
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
     * @return TrainingEvaluations
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
     * @return TrainingEvaluations
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
    
    /**
     * Set trainee
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $trainee
     * @return TrainingEvaluations
     */
    public function setTrainee(\Tatweer\TrainingBundle\Entity\Users $trainee = null)
    {
        $this->trainee = $trainee;

        return $this;
    }

    /**
     * Get trainee
     *
     * @return \Tatweer\TrainingBundle\Entity\Users 
     */
    public function getTrainee()
    {
        return $this->trainee;
    }

    /**
     * Set training
     *
     * @param \Tatweer\TrainingBundle\Entity\Trainings $training
     * @return TrainingEvaluations
     */
    public function setTraining(\Tatweer\TrainingBundle\Entity\Trainings $training = null)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return \Tatweer\TrainingBundle\Entity\Trainings 
     */
    public function getTraining()
    {
        return $this->training;
    }
}
