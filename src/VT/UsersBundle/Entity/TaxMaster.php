<?php

namespace VT\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * TaxMaster
 *
 * @ORM\Table(name="tax_master")
 * @ORM\Entity(repositoryClass="VT\UsersBundle\Repository\TaxMasterRepository")
 */
class TaxMaster extends AbstractVitruEntity implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="string")
     */
    private $percentage;
    
    /**
    * Get name
    * @return string 
    */
    public function getName()
    {
        return $this->name;
    }
    
    /**
    * Set name
    * @return $this
    */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
    * Get percentage
    * @return string 
    */
    public function getPercentage()
    {
        return $this->percentage;
    }
    
    /**
    * Set percentage
    * @return $this
    */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

    public function jsonSerialize(){}
}

