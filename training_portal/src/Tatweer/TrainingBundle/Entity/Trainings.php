<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trainings
 *
 * @ORM\Table(name="trainings", indexes={@ORM\Index(name="trainings_training_needs_id_idx", columns={"training_needs_program_id"}), @ORM\Index(name="trainings_languageid_fk_idx", columns={"language_id"}), @ORM\Index(name="trainings_deptbudgetid_fk_idx", columns={"department_budget_id"}), @ORM\Index(name="trainings_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="trainings_modifiedby_fk_idx", columns={"modified_by"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\TrainingsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Trainings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_training", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTraining;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="provider_name", type="string", length=255, nullable=true)
     */
    private $providerName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved_by_hr", type="integer", nullable=true)
     */
    private $approvedByHr;

    /**
     * @var string
     *
     * @ORM\Column(name="language_other", type="string", length=100, nullable=true)
     */
    private $languageOther;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chosen_by_employee", type="boolean", nullable=true)
     */
    private $chosenByEmployee;

    /**
     * @var string
     *
     * @ORM\Column(name="training_content", type="string", length=255, nullable=true)
     */
    private $trainingContent;

    /**
     * @var string
     *
     * @ORM\Column(name="trainee_attendance_report", type="string", length=255, nullable=true)
     */
    private $traineeAttendanceReport;

    /**
     * @var string
     *
     * @ORM\Column(name="employee_roles", type="text", nullable=true)
     */
    private $employeeRoles;

    /**
     * @var string
     *
     * @ORM\Column(name="hr_recommendations", type="text", nullable=true)
     */
    private $hrRecommendations;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tna", type="boolean", nullable=true)
     */
    private $tna;

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
     * @var string
     *
     * @ORM\Column(name="trainingscol", type="string", length=45, nullable=true)
     */
   // private $trainingscol;

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
     * @var \DepartmentBudgets
     *
     * @ORM\ManyToOne(targetEntity="DepartmentBudgets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department_budget_id", referencedColumnName="id_dept_budget")
     * })
     */
    private $departmentBudget;

    /**
     * @var \TrainingNeedsValues
     *
     * @ORM\ManyToOne(targetEntity="TrainingNeedsValues")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="training_needs_program_id", referencedColumnName="id_value")
     * })
     */
    private $trainingNeedsProgram;

    /**
     * @var \Languages
     *
     * @ORM\ManyToOne(targetEntity="Languages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="language_id", referencedColumnName="id_language")
     * })
     */
    private $language;

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
     * Get idTraining
     *
     * @return integer 
     */
    public function getIdTraining()
    {
        return $this->idTraining;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Trainings
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
     * Set providerName
     *
     * @param string $providerName
     * @return Trainings
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    /**
     * Get providerName
     *
     * @return string 
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Trainings
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
     * @return Trainings
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
     * Set duration
     *
     * @param integer $duration
     * @return Trainings
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Trainings
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Trainings
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set approvedByHr
     *
     * @param boolean $approvedByHr
     * @return Trainings
     */
    public function setApprovedByHr($approvedByHr)
    {
        $this->approvedByHr = $approvedByHr;

        return $this;
    }

    /**
     * Get approvedByHr
     *
     * @return boolean 
     */
    public function getApprovedByHr()
    {
        return $this->approvedByHr;
    }

    /**
     * Set languageOther
     *
     * @param string $languageOther
     * @return Trainings
     */
    public function setLanguageOther($languageOther)
    {
        $this->languageOther = $languageOther;

        return $this;
    }

    /**
     * Get languageOther
     *
     * @return string 
     */
    public function getLanguageOther()
    {
        return $this->languageOther;
    }

    /**
     * Set chosenByEmployee
     *
     * @param boolean $chosenByEmployee
     * @return Trainings
     */
    public function setChosenByEmployee($chosenByEmployee)
    {
        $this->chosenByEmployee = $chosenByEmployee;

        return $this;
    }

    /**
     * Get chosenByEmployee
     *
     * @return boolean 
     */
    public function getChosenByEmployee()
    {
        return $this->chosenByEmployee;
    }

    /**
     * Set trainingContent
     *
     * @param string $trainingContent
     * @return Trainings
     */
    public function setTrainingContent($trainingContent)
    {
        $this->trainingContent = $trainingContent;

        return $this;
    }

    /**
     * Get trainingContent
     *
     * @return string 
     */
    public function getTrainingContent()
    {
        return $this->trainingContent;
    }

    /**
     * Set traineeAttendanceReport
     *
     * @param string $traineeAttendanceReport
     * @return Trainings
     */
    public function setTraineeAttendanceReport($traineeAttendanceReport)
    {
        $this->traineeAttendanceReport = $traineeAttendanceReport;

        return $this;
    }

    /**
     * Get traineeAttendanceReport
     *
     * @return string 
     */
    public function getTraineeAttendanceReport()
    {
        return $this->traineeAttendanceReport;
    }

    /**
     * Set employeeRoles
     *
     * @param string $employeeRoles
     * @return Trainings
     */
    public function setEmployeeRoles($employeeRoles)
    {
        $this->employeeRoles = $employeeRoles;

        return $this;
    }

    /**
     * Get employeeRoles
     *
     * @return string 
     */
    public function getEmployeeRoles()
    {
        return $this->employeeRoles;
    }

    /**
     * Set hrRecommendations
     *
     * @param string $hrRecommendations
     * @return Trainings
     */
    public function setHrRecommendations($hrRecommendations)
    {
        $this->hrRecommendations = $hrRecommendations;

        return $this;
    }

    /**
     * Get hrRecommendations
     *
     * @return string 
     */
    public function getHrRecommendations()
    {
        return $this->hrRecommendations;
    }

    /**
     * Set tna
     *
     * @param boolean $tna
     * @return Trainings
     */
    public function setTna($tna)
    {
        $this->tna = $tna;

        return $this;
    }

    /**
     * Get tna
     *
     * @return boolean 
     */
    public function getTna()
    {
        return $this->tna;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Trainings
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
     * @return Trainings
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
     * Set trainingscol
     *
     * @param string $trainingscol
     * @return Trainings
     */
    public function setTrainingscol($trainingscol)
    {
        $this->trainingscol = $trainingscol;

        return $this;
    }

    /**
     * Get trainingscol
     *
     * @return string 
     */
    public function getTrainingscol()
    {
        return $this->trainingscol;
    }

    /**
     * Set createdBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $createdBy
     * @return Trainings
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
     * Set departmentBudget
     *
     * @param \Tatweer\TrainingBundle\Entity\DepartmentBudgets $departmentBudget
     * @return Trainings
     */
    public function setDepartmentBudget(\Tatweer\TrainingBundle\Entity\DepartmentBudgets $departmentBudget = null)
    {
        $this->departmentBudget = $departmentBudget;

        return $this;
    }

    /**
     * Get departmentBudget
     *
     * @return \Tatweer\TrainingBundle\Entity\DepartmentBudgets 
     */
    public function getDepartmentBudget()
    {
        return $this->departmentBudget;
    }

    /**
     * Set trainingNeedsProgram
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingNeedsValues $trainingNeedsProgram
     * @return Trainings
     */
    public function setTrainingNeedsProgram(\Tatweer\TrainingBundle\Entity\TrainingNeedsValues $trainingNeedsProgram = null)
    {
        $this->trainingNeedsProgram = $trainingNeedsProgram;

        return $this;
    }

    /**
     * Get trainingNeedsProgram
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingNeedsValues 
     */
    public function getTrainingNeedsProgram()
    {
        return $this->trainingNeedsProgram;
    }

    /**
     * Set language
     *
     * @param \Tatweer\TrainingBundle\Entity\Languages $language
     * @return Trainings
     */
    public function setLanguage(\Tatweer\TrainingBundle\Entity\Languages $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Tatweer\TrainingBundle\Entity\Languages 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set modifiedBy
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $modifiedBy
     * @return Trainings
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
     * Override PHP magic function __toString() to return the current object field "Username"
     */
    public function __toString(){
        return (string)$this->getIdTraining();
    }
    
    
}
