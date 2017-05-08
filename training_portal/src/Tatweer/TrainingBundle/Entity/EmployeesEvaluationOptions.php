<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeesEvaluationOptions
 *
 * @ORM\Table(name="employees_evaluation_options", indexes={@ORM\Index(name="employees_evaluation_options_sectionid_fk_idx", columns={"section_id"})})
 * @ORM\Entity
 */
class EmployeesEvaluationOptions
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="id_option", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOption;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ar", type="string", length=100, nullable=true)
     */
    private $nameAr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=100, nullable=true)
     */
    private $nameEn;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

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
     * Get idOption
     *
     * @return boolean 
     */
    public function getIdOption()
    {
        return $this->idOption;
    }

    /**
     * Set nameAr
     *
     * @param string $nameAr
     * @return EmployeesEvaluationOptions
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
     * @return EmployeesEvaluationOptions
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
     * @return EmployeesEvaluationOptions
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
     * Set section
     *
     * @param \Tatweer\TrainingBundle\Entity\EmployeesEvaluationSections $section
     * @return EmployeesEvaluationOptions
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
