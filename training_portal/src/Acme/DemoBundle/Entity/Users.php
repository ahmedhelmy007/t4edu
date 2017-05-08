<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})}, indexes={@ORM\Index(name="users_createdby_fk_idx", columns={"created_by"}), @ORM\Index(name="users_modifiedby_fk_idx", columns={"modified_by"})})
 * @ORM\HasLifecycleCallbacks
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;
    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="employee_grade", type="string", length=45, nullable=true)
     */
    private $employeeGrade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="able_to_request_training", type="boolean", nullable=true)
     */
    private $ableToRequestTraining;

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
     * @ORM\OneToMany(targetEntity="Permissions", mappedBy="user"  )
     **/
    private $roleUserGroup;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="userIds")
     * @ORM\JoinTable(name="permissions",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id_user")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id_role")}
     *  )
     */
    
    private $roleIds;
    
    
    public function __construct()
    {
        $this->roleIds = new ArrayCollection();
        $this->roleUserGroup = new ArrayCollection();
        
        $this->salt = md5(uniqid(null, true));

    }
    
    
    
    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idUser;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     * implementing UserInterface getUsername() method
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     * implementing UserInterface getSalt() method
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->salt;
    }
    
    /**
     * @inheritDoc
     * implementing UserInterface getPassword() method
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     * implementing UserInterface getRoles() method
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     * implementing UserInterface eraseCredentials() method
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->idUser,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->idUser,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    
    /**
     * Set employeeGrade
     *
     * @param string $employeeGrade
     * @return Users
     */
    public function setEmployeeGrade($employeeGrade)
    {
        $this->employeeGrade = base64_encode($employeeGrade);

        return $this;
    }

    /**
     * Get employeeGrade
     *
     * @return string 
     */
    public function getEmployeeGrade()
    {
        return base64_decode($this->employeeGrade);
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Users
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
     * Set ableToRequestTraining
     *
     * @param boolean $ableToRequestTraining
     * @return Users
     */
    public function setAbleToRequestTraining($ableToRequestTraining)
    {
        $this->ableToRequestTraining = $ableToRequestTraining;

        return $this;
    }

    /**
     * Get ableToRequestTraining
     *
     * @return boolean 
     */
    public function getAbleToRequestTraining()
    {
        return $this->ableToRequestTraining;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Users
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
     * @return Users
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
     * @param \Acme\DemoBundle\Entity\Users $createdBy
     * @return Users
     */
    public function setCreatedBy(\Acme\DemoBundle\Entity\Users $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Acme\DemoBundle\Entity\Users 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedBy
     *
     * @param \Acme\DemoBundle\Entity\Users $modifiedBy
     * @return Users
     */
    public function setModifiedBy(\Acme\DemoBundle\Entity\Users $modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return \Acme\DemoBundle\Entity\Users 
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    

    /**
     * Override PHP magic function __toString() to return the current object field "Username"
     */
    public function __toString(){
        return (string)$this->getUsername();
    }
    
    
    
    /**
    * @ORM\PrePersist
    */
    public function setCreatedValue()
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
     * Set roleUserGroup
     *
     * @param $roleUserGroup
     */
    public function setRoleUserGroup($roleUserGroup)
    {
        $this->roleUserGroup = $roleUserGroup;

        return $this;
    }

    /**
     * Get roleUserGroup
     * 
     */
    public function getRoleUserGroup()
    {
        return $this->roleUserGroup;
    }
    
    /**
     * Add roleUserGroup
     *
     * @param \Acme\DemoBundle\Entity\Permissions  $roleUserGroup
     * @return Permission
     */
    public function addRoleUserGroup(\Acme\DemoBundle\Entity\Permissions $roleUserGroup)
    {
        $this->roleUserGroup[] = $roleUserGroup;

        return $this;
    }

    /**
     * Remove roleUserGroup
     *
     * @param \Acme\DemoBundle\Entity\Permissions  $roleUserGroup
     */
    public function removeRoleUserGroup(\Acme\DemoBundle\Entity\Permissions $roleUserGroup)
    {
        $this->roleUserGroup->removeElement($roleUserGroup);
    }
    
    
    
    
    
    public function getRoleIds() {
        return $this->roleIds;
    }

    public function setRoleIds($roleids) {
        $this->roleIds = $roleids;
    }
    
    /**
     * Add roleIds
     *
     * @param \Acme\DemoBundle\Entity\Roles $roleIds
     * @return Users
     */
    public function addRoleId(\Acme\DemoBundle\Entity\Roles $roleIds)
    {
        $this->roleIds[] = $roleIds;
        $roleIds->addUserId($this);

        return $this;
    }

    /**
     * Remove roleIds
     *
     * @param \Acme\DemoBundle\Entity\Groups $roleIds
     */
    public function removeRoleId(\Acme\DemoBundle\Entity\Roles $roleIds)
    {
        $this->roleIds->removeElement($roleIds);
    }
    
/*public function getRoleIdsAsCollection()
{
    return $this->roleIds;
}*/



    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
