<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Roles
{
    /**
     * @var smallint
     *
     * @ORM\Column(name="id_role", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRole;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ar", type="string", length=45, nullable=true)
     */
    private $nameAr;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=45, nullable=true)
     */
    private $nameEn;

   /**
     * @ORM\OneToMany(targetEntity="Permissions", mappedBy="role"  )
     **/
    private $roleUserGroup;

   /**
    * @ORM\ManyToMany(targetEntity="Users", mappedBy="roleIds")
    * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(name="Roles", referencedColumnName="id_role")},
    *  inverseJoinColumns={@ORM\JoinColumn(name="Users", referencedColumnName="id_user")})
    */
 
    private $userIds;


    public function __construct()
    {
         $this->userIds = new ArrayCollection();
         $this->roleUserGroup = new ArrayCollection();
    }
    
    
    
    /**
     * Get idRole
     *
     * @return boolean 
     */
    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * Set nameAr
     *
     * @param string $nameAr
     * @return Roles
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
     * @return Roles
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
     * Override PHP magic function __toString() to return the current object field "name"
     */
    public function __toString(){
        return (string)$this->getNameAr();
    }
     
    public function getUserIds() {
        return $this->userIds;
    }

    public function setUserIds($userids) {
        $this->userIds = $userids;
    }
    

    /**
     * Add userIds
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $userIds
     * @return Roles
     */
    public function addUserIds(\Tatweer\TrainingBundle\Entity\Users $userIds)
    {
        $this->userIds[] = $userIds;
        $userIds->addRoleId($this);
        return $this;
    }

    /**
     * Remove userIds
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $userIds
     */
    public function removeUserIds(\Tatweer\TrainingBundle\Entity\Users $userIds)
    {
        $this->userIds->removeElement($userIds);
    }
    
    

    /**
     * Add roleUserGroup
     *
     * @param \Tatweer\TrainingBundle\Entity\Permissions $roleUserGroup
     * @return Roles
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

    /**
     * Add userIds
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $userIds
     * @return Roles
     */
    public function addUserId(\Tatweer\TrainingBundle\Entity\Users $userIds)
    {
        $this->userIds[] = $userIds;

        return $this;
    }

    /**
     * Remove userIds
     *
     * @param \Tatweer\TrainingBundle\Entity\Users $userIds
     */
    public function removeUserId(\Tatweer\TrainingBundle\Entity\Users $userIds)
    {
        $this->userIds->removeElement($userIds);
    }
}
