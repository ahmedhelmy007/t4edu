<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CccCcc
 * 
 * @ORM\Entity
 * @ORM\Table(name="ccc_ccc")
 * 
 */

class CccCcc
{

    /**
     * @var smallint
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

   /**
    * @ORM\ManyToMany(targetEntity="AaaAaa", mappedBy="ccc")
    * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(name="ccc_ccc_id", referencedColumnName="id")},
    *  inverseJoinColumns={@ORM\JoinColumn(name="AaaAaa", referencedColumnName="id")})
    */
 
    private $aaa;
    
    /**
     * Set name
     *
     * @param string $name
     * @return Budgets
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $aaaBbbCccCollection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aaaBbbCccCollection = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add aaaBbbCccCollection
     *
     * @param \Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection
     * @return CccCcc
     */
    public function addAaaBbbCccCollection(\Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection)
    {
        $this->aaaBbbCccCollection[] = $aaaBbbCccCollection;

        return $this;
    }

    /**
     * Remove aaaBbbCccCollection
     *
     * @param \Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection
     */
    public function removeAaaBbbCccCollection(\Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection)
    {
        $this->aaaBbbCccCollection->removeElement($aaaBbbCccCollection);
    }

    /**
     * Get aaaBbbCccCollection
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAaaBbbCccCollection()
    {
        return $this->aaaBbbCccCollection;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return CccCcc
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
