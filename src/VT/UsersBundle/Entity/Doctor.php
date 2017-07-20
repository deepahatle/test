<?php

namespace VT\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\ISoftDeleteAware;
use VT\VTCoreBundle\Entity\IMultiLabAware;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * Doctor
 *
 * @ORM\Table(name="doctor")
 * @ORM\Entity(repositoryClass="VT\UsersBundle\Repository\DoctorRepository")
 */
class Doctor extends AbstractVitruEntity implements  ISoftDeleteAware, IMultiLabAware, \JsonSerializable
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
     * @ORM\Column(name="email", type="string")
     */
    private $email;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="mobile", type="string")
     */
    private $mobile;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="address", type="string")
     */
    private $address;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="city", type="string")
     */
    private $city;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="string")
     */
    private $percentage;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\LabsBundle\Entity\Lab", fetch="EAGER")
     * @ORM\JoinColumn(name="lab_id", referencedColumnName = "row_id")
     *
     */
    private $lab;

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
    * Get email
    * @return string 
    */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
    * Set email
    * @return $this
    */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
    * Get mobile
    * @return string 
    */
    public function getMobile()
    {
        return $this->mobile;
    }
    
    /**
    * Set mobile
    * @return $this
    */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
    * Get address
    * @return string 
    */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
    * Set address
    * @return $this
    */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
    * Get city
    * @return string 
    */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
    * Set city
    * @return $this
    */
    public function setCity($city)
    {
        $this->city = $city;
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

    /**
    * Get lab
    * @return mixed 
    */
    public function getLab()
    {
        return $this->lab;
    }
    
    /**
    * Set lab
    * @return $this
    */
    public function setLab($lab)
    {
        $this->lab = $lab;
        return $this;
    }  

    function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "mobile" => $this->getMobile(),
            "email" => $this->getEmail(),
            "address" => $this->getAddress(),
            "city" => $this->getCity(),
            "percentage" => $this->getPercentage()
        );
    }

}

