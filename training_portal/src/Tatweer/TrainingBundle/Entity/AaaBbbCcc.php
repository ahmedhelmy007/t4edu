<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AaaBbbCcc
 * 
 * @ORM\Entity
 * @ORM\Table(name="aaa_bbb_ccc")
 * 
 */

class AaaBbbCcc
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
     * @ORM\Column(name="value", type="string", length=100, nullable=true)
     */
    private $value;
	
    /**
     * @var \Tatweer\TrainingBundle\Entity\AaaAaa
     *
     * @ORM\ManyToOne(targetEntity="AaaAaa", inversedBy="aaaBbbCccCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aaa_aaa_id", referencedColumnName="id" )
     * })
     */
    private $aaaAaa;

    /**
     * @var \Tatweer\TrainingBundle\Entity\BbbBbb
     *
     * @ORM\ManyToOne(targetEntity="BbbBbb", inversedBy="aaaBbbCccCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bbb_bbb_id", referencedColumnName="id" )
     * })
     */
    private $bbbBbb;

    /**
     * @var \Tatweer\TrainingBundle\Entity\CccCcc
     *
     * @ORM\ManyToOne(targetEntity="CccCcc", inversedBy="aaaBbbCccCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ccc_ccc_id", referencedColumnName="id" )
     * })
     */
    private $cccCcc;


    /**
     * Set aaaAaa
     *
     * @param \Tatweer\TrainingBundle\Entity\AaaAaa $aaaAaa
     * @return AaaBbbCcc
     */
    public function setAaaAaa(\Tatweer\TrainingBundle\Entity\AaaAaa $aaaAaa = null)
    {
        $this->aaaAaa = $aaaAaa;

        return $this;
    }

    /**
     * Get aaaAaa
     *
     * @return \Tatweer\TrainingBundle\Entity\AaaAaa 
     */
    public function getAaaAaa()
    {
        return $this->aaaAaa;
    }

    /**
     * Set bbbBbb
     *
     * @param \Tatweer\TrainingBundle\Entity\BbbBbb $bbbBbb
     * @return AaaBbbCcc
     */
    public function setBbbBbb(\Tatweer\TrainingBundle\Entity\BbbBbb $bbbBbb = null)
    {
        $this->bbbBbb = $bbbBbb;

        return $this;
    }

    /**
     * Get bbbBbb
     *
     * @return \Tatweer\TrainingBundle\Entity\BbbBbb 
     */
    public function getBbbBbb()
    {
        return $this->bbbBbb;
    }

    /**
     * Set cccCcc
     *
     * @param \Tatweer\TrainingBundle\Entity\CccCcc $cccCcc
     * @return AaaBbbCcc
     */
    public function setCccCcc(\Tatweer\TrainingBundle\Entity\CccCcc $cccCcc = null)
    {
        $this->cccCcc = $cccCcc;

        return $this;
    }

    /**
     * Get cccCcc
     *
     * @return \Tatweer\TrainingBundle\Entity\CccCcc 
     */
    public function getCccCcc()
    {
        return $this->cccCcc;
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
     * Set name
     *
     * @param string $name
     * @return Budgets
     */
    public function setName($name)
    {
        $this->value = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->value;
    }

    /**
     * Set price
     *
     * @param string $value
     * @return value
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function __toString() {
        return $this->value;
    }
}
