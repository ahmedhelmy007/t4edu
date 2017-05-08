<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingNeedsValues
 *
 * @ORM\Table(name="training_needs_values", indexes={@ORM\Index(name="training_needs_values_needid_fk_idx", columns={"training_need_id"}), @ORM\Index(name="training_needs_values_optionid_fk_idx", columns={"selected_option_id"}), @ORM\Index(name="training_needs_values_createdby_idx", columns={"created_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TrainingNeedsValues
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
     * @var string
     *
     * @ORM\Column(name="section", type="string", nullable=true)
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="value_ar", type="string", length=255, nullable=true)
     */
    private $valueAr;

    /**
     * @var string
     *
     * @ORM\Column(name="value_en", type="string", length=255, nullable=true)
     */
    private $valueEn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

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
     * @var \TrainingNeeds
     *
     * @ORM\ManyToOne(targetEntity="TrainingNeeds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="training_need_id", referencedColumnName="id_need")
     * })
     */
    private $trainingNeed;

    /**
     * @var \TrainingNeedsOptions
     *
     * @ORM\ManyToOne(targetEntity="TrainingNeedsOptions")
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
     * Set section
     *
     * @param string $section
     * @return TrainingNeedsValues
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set valueAr
     *
     * @param string $valueAr
     * @return TrainingNeedsValues
     */
    public function setValueAr($valueAr)
    {
        $this->valueAr = $valueAr;

        return $this;
    }

    /**
     * Get valueAr
     *
     * @return string 
     */
    public function getValueAr()
    {
        return $this->valueAr;
    }

    /**
     * Set valueEn
     *
     * @param string $valueEn
     * @return TrainingNeedsValues
     */
    public function setValueEn($valueEn)
    {
        $this->valueEn = $valueEn;

        return $this;
    }

    /**
     * Get valueEn
     *
     * @return string 
     */
    public function getValueEn()
    {
        return $this->valueEn;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return TrainingNeedsValues
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
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return TrainingNeedsValues
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
     * Set trainingNeed
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingNeeds $trainingNeed
     * @return TrainingNeedsValues
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
     * Set selectedOption
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingNeedsOptions $selectedOption
     * @return TrainingNeedsValues
     */
    public function setSelectedOption(\Tatweer\TrainingBundle\Entity\TrainingNeedsOptions $selectedOption = null)
    {
        $this->selectedOption = $selectedOption;

        return $this;
    }

    /**
     * Get selectedOption
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingNeedsOptions 
     */
    public function getSelectedOption()
    {
        return $this->selectedOption;
    }
    
            
    /**
    * @ORM\PrePersist
    */
    public function setCreatedDateValue()
    {
        $this->createdDate = new \DateTime();
    }
    


    /**
     * Override PHP magic function __toString() to return the current object field "Username"
     */
    public function __toString(){
        return (string)$this->getValueEn();
    }
    
}
