<?php

namespace Tatweer\TrainingBundle\Entity;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups", indexes={@ORM\Index(name="groups_createddby_idx", columns={"created_by"}), @ORM\Index(name="groups_parent_idx", columns={"parent_id"}), @ORM\Index(name="groups_modifiedby_idx", columns={"modified_by"})})
 * @ORM\Entity(repositoryClass="Tatweer\TrainingBundle\Entity\GroupsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Groups
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
     * @ORM\OneToMany(targetEntity="Permissions", mappedBy="group"  )
     **/
    private $roleUserGroup;
    
    public function __construct()
    {
         $this->roleUserGroup = new ArrayCollection();
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * @return Groups
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
     * Add roleUserGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Permissions $roleUserGroup
     * @return Groups
     */
    public function addRoleUserGroup(\Tatweer\TrainingBundle\Entity\Permissions $roleUserGroup)
    {
        $this->roleUserGroup[] = $roleUserGroup;

        return $this;
    }

    /**
     * Remove roleUserGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Permissions $roleUserGroup
     */
    public function removeRoleUserGroup(\Tatweer\TrainingBundle\Entity\Permissions $roleUserGroup)
    {
        $this->roleUserGroup->removeElement($roleUserGroup);
    }

    /**
     * Get roleUserGroup
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoleUserGroup()
    {
        return $this->roleUserGroup;
    }
}
