<?php

namespace VT\LabsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * Lab
 *
 * @ORM\Table(name="lab")
 * @ORM\Entity(repositoryClass="VT\LabsBundle\Repository\LabRepository")
 */
class Lab extends AbstractVitruEntity implements \JsonSerializable
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
     * @ORM\Column(name="pincode", type="integer")
     */
    private $pincode;

    /**
     * @var integer
     *
     * @ORM\Column(name="registration_no", type="string")
     */
    private $registrationNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="doctor", type="string")
     */
    private $doctor;

    /**
     * @var integer
     *
     * @ORM\Column(name="signature", type="string")
     */
    private $signature;

    /**
     * @var integer
     *
     * @ORM\Column(name="logo", type="string")
     */
    private $logo;

    /**
     *
     * @ORM\OneToOne(targetEntity = "VT\LoginBundle\Entity\Login", fetch="EAGER")
     * @ORM\JoinColumn(name="login_id", referencedColumnName = "row_id")
     *
     */
    private $login;

    /**
     * @var integer
     *
     * @ORM\Column(name="free_credits", type="string")
     */
    private $freeCredits = 500;

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
     * Get pincode
     * @return string
     */
    public function getPincode()
    {
        return $this->pincode;
    }

    /**
     * Set pincode
     * @return $this
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;
        return $this;
    }

    /**
     * Get registrationNo
     * @return
     */
    public function getRegistrationNo()
    {
        return $this->registrationNo;
    }

    /**
     * Set registrationNo
     * @return $this
     */
    public function setRegistrationNo($registrationNo)
    {
        $this->registrationNo = $registrationNo;
        return $this;
    }

    /**
     * Get login
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Get doctor
     * @return string
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Set doctor
     * @return $this
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
        return $this;
    }

    /**
     * Get signature
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set signature
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * Get logo
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * Get freeCredits
     * @return integer
     */
    public function getFreeCredits()
    {
        return $this->freeCredits;
    }

    /**
     * Set freeCredits
     * @return $this
     */
    public function setFreeCredits($freeCredits)
    {
        $this->freeCredits = $freeCredits;
        return $this;
    }

    function jsonSerialize()
    {
        return array(
            'name' => $this->getName(),
            'logo' => $this->getLogo(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'pincode' => $this->getPincode(),
            'doctorName' => $this->getDoctor(),
            'doctorSignature' => $this->getSignature(),
            'freeCredits' => $this->getFreeCredits()
        );
    }
}

