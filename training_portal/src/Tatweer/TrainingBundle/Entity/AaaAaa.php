<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AaaAaa
 * 
 * @ORM\Table(name="aaa_aaa")
 * @ORM\Entity
 * 
 */

class AaaAaa
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
     * @ORM\ManyToMany(targetEntity="BbbBbb", inversedBy="aaa")
     * @ORM\JoinTable(name="aaa_bbb_ccc",
     *      joinColumns={@ORM\JoinColumn(name="aaa_aaa_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="bbb_bbb_id", referencedColumnName="id")}
     *  )
     */
    
    private $bbb;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="CccCcc", inversedBy="aaa")
     * @ORM\JoinTable(name="aaa_bbb_ccc",
     *      joinColumns={@ORM\JoinColumn(name="aaa_aaa_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ccc_ccc_id", referencedColumnName="id")}
     *  )
     */
    
    private $ccc;
    
    /**
     * @ORM\OneToMany(targetEntity="AaaBbbCcc", mappedBy="aaaAaa", cascade={"persist"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $aaaBbbCccCollection;
    
    /**
     * @ORM\OneToMany(targetEntity="AaaBbbCcc", mappedBy="aaaAaa", cascade={"remove"})
     * used for delete multiple Rentalperiods
     */
//    private $aaaBbbCccCollection2;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aaaBbbCccCollection = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Add aaaBbbCccCollection
     *
     * @param \Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection
     * @return AaaAaa
     */
    public function addAaaBbbCccCollection(\Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection)
    {
        $this->aaaBbbCccCollection[] = $aaaBbbCccCollection;

        return $this;
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
     * @return AaaAaa
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function getBbb() {
        return $this->bbb;
    }

    public function setBbb($bbb) {
        $this->bbb = $bbb;
    }
    
    public function getCcc() {
        return $this->ccc;
    }

    public function setCcc($ccc) {
        $this->ccc = $ccc;
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
     * Remove aaaBbbCccCollection
     *
     * @param \Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection
     */
    public function removeAaaBbbCccCollection(\Tatweer\TrainingBundle\Entity\AaaBbbCcc $aaaBbbCccCollection)
    {
        $this->aaaBbbCccCollection->removeElement($aaaBbbCccCollection);
    }

//    public function getAaaBbbCccCollection2() {
//        return $this->aaaBbbCccCollection2;
//    }
//
//    public function setAaaBbbCccCollection2($aaaBbbCccCollection2) {
//        $this->aaaBbbCccCollection2 = $aaaBbbCccCollection2;
//    }
    
    
}
