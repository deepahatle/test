<?php

namespace VT\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="VT\UsersBundle\Repository\UserRepository")
 */
class User extends AbstractVitruEntity implements \JsonSerializable
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
     * @ORM\Column(name="gender", type="string")
     */
    private $gender;
     
    /**
     * @var \Date
     *
     * @ORM\Column(name="dob", type="date")
     */
    private $dob;

    /**
     *
     * @ORM\OneToOne(targetEntity = "VT\LoginBundle\Entity\Login", fetch="EAGER")
     * @ORM\JoinColumn(name="login_id", referencedColumnName = "row_id")
     *
     */
    private $login;

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
    * Get gender
    * @return string 
    */
    public function getGender()
    {
        return $this->gender;
    }
    
    /**
    * Set gender
    * @return $this
    */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
    * Get dob
    * @return \Date dob
    */
    public function getDob()
    {
        return $this->dob;
    }
    
    /**
    * Set dob
    * @return $this
    */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
    * Get login
    * @return mixed 
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

    function jsonSerialize(){
        $dateObj = $this->getDob();
        $date = $dateObj->format('d-m-Y');
        return array(
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'address' => $this->getAddress(),
            'city' => $this->getCity(),
            'gender' => $this->getGender(),
            'dob' => $date
        );
    }
}