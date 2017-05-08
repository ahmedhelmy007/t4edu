<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeesEvaluationCriterias
 *
 * @ORM\Table(name="employees_evaluation_criterias", indexes={@ORM\Index(name="employees_evaluation_criterias_sectionid_fk_idx", columns={"section_id"}), @ORM\Index(name="employees_evaluation_criterias_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="employees_evaluation_criterias_modifiedby_fk_idx", columns={"modified_by"})})
 * @ORM\Entity
 */
class EmployeesEvaluationCriterias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_criteria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCriteria;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ar", type="string", length=255, nullable=true)
     */
    private $nameAr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255, nullable=true)
     */
    private $nameEn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

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
     * @var \EmployeesEvaluationSections
     *
     * @ORM\ManyToOne(targetEntity="EmployeesEvaluationSections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id_section")
     * })
     */
    private $section;



    /**
     * Get idCriteria
     *
     * @return integer 
     */
    public function getIdCriteria()
    {
        return $this->idCriteria;
    }

    /**
     * Set nameAr
     *
     * @param string $nameAr
     * @return EmployeesEvaluationCriterias
     */
    public function setNameAr($nameAr)
    {
        $this->nameAr = $nameAr;

        return $this;
    }

    /**
     * Get nameAr
     *
     * @return string 
     */
    public function getNameAr()
    {
        return $this->nameAr;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     * @return EmployeesEvaluationCriterias
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * Get nameEn
     *
     * @return string 
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return EmployeesEvaluationCriterias
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return EmployeesEvaluationCriterias
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
     * @return EmployeesEvaluationCriterias
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
     * @return EmployeesEvaluationCriterias
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
     * @return EmployeesEvaluationCriterias
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
     * Set section
     *
     * @param \Tatweer\TrainingBundle\Entity\EmployeesEvaluationSections $section
     * @return EmployeesEvaluationCriterias
     */
    public function setSection(\Tatweer\TrainingBundle\Entity\EmployeesEvaluationSections $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \Tatweer\TrainingBundle\Entity\EmployeesEvaluationSections 
     */
    public function getSection()
    {
        return $this->section;
    }
}
