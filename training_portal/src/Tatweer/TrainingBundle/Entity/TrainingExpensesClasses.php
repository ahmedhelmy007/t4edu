<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingExpensesClasses
 *
 * @ORM\Table(name="training_expenses_classes")
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\TrainingExpensesClassesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TrainingExpensesClasses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_class", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClass;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="manageable", type="boolean", nullable=false)
     */
    private $manageable;


    /**
     * Get idClass
     *
     * @return boolean 
     */
    public function getIdClass()
    {
        return $this->idClass;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TrainingExpensesClasses
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
     * Set manageable
     *
     * @param boolean $manageable
     * @return TrainingExpensesClasses
     */
    public function setManageable($manageable)
    {
        $this->manageable = $manageable;

        return $this;
    }

    /**
     * Get manageable
     *
     * @return boolean 
     */
    public function getManageable()
    {
        return $this->manageable;
    }
    
    
        
    /**
    * @ORM\PrePersist
    */
    public function setManageableValue()
    {
        $this->manageable = 1;
    }
    

}
