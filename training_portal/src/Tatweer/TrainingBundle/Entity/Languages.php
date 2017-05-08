<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Languages
 *
 * @ORM\Table(name="languages")
 * @ORM\Entity
 */
class Languages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_language", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLanguage;

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
     * Get idLanguage
     *
     * @return integer 
     */
    public function getIdLanguage()
    {
        return $this->idLanguage;
    }

    /**
     * Set nameAr
     *
     * @param string $nameAr
     * @return Languages
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
     * @return Languages
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
     * Override PHP magic function __toString() to return the current object field "Username"
     */
    public function __toString(){
     
        return (string)$this->getNameAr();
    }
    
}
