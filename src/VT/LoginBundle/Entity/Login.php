<?php

namespace VT\LoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;
use VT\VTCoreBundle\Entity\ISoftDeleteAware;

/**
 * Login
 *
 * @ORM\Table(name="login")
 * @ORM\Entity(repositoryClass="VT\LoginBundle\Repository\LoginRepository")
 */
class Login extends AbstractVitruEntity implements AdvancedUserInterface, ISoftDeleteAware, \Serializable, \JsonSerializable
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
     * @ORM\Column(name="mobileno", type="string")
     */
    private $mobileNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="username", type="string")
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="pass", type="string")
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_type", type="string")
     */
    private $userType;

    /**
     * @var integer
     *
     * @ORM\Column(name="salt", type="string")
     */
    private $salt;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_active", type="string")
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="roles", type="string")
     */
    private $rolesAsString;

    /**
     * @var integer
     *
     * @ORM\Column(name="expiry", type="datetime")
     */
    private $expiry;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_trial", type="string")
     */
    private $isTrial;

    /**
     *
     * This is not stored in the DB.
     *
     * @var string
     */
    private $plainPassword;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * @return string
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * @param string $mobileNo
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * Get expiry
     * @return \DateTime
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * Set expiry
     * @return $this
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }

    /**
     * Get isTrial
     * @return string
     */
    public function getIsTrial()
    {
        return $this->isTrial;
    }

    /**
     * Set isTrial
     * @return $this
     */
    public function setIsTrial($isTrial)
    {
        $this->isTrial = $isTrial;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        $isActive = $this->getIsActive();
        $expiry = $this->getExpiry();
        if ($isActive == 'No')
            return false;
        if (isset($expiry) && $expiry < new \DateTime('now'))
            return false;

        return true;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array The user roles
     */
    public function getRoles()
    {
        $exploded = explode(",", $this->getRolesAsString());
        return array_unique($exploded);
    }

    /**
     * @param $roles array
     */
    public function setRoles(array $roles)
    {
        $this->setRolesAsString(implode(",", $roles));
    }

    /**
     * @return string
     */
    public function getRolesAsString()
    {
        return $this->rolesAsString;
    }

    /**
     * @param string $rolesAsString
     */
    public function setRolesAsString($rolesAsString)
    {
        $this->rolesAsString = $rolesAsString;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        $data = array(
            $this->getId(),
            $this->name,
            $this->mobileNo,
            $this->username,
            $this->password,
            $this->isActive,
            $this->expiry,
            $this->userType,
            $this->isTrial,
        );
        return serialize($data);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = list (
            $this->id,
            $this->name,
            $this->mobileNo,
            $this->username,
            $this->password,
            $this->isActive,
            $this->expiry,
            $this->userType,
            $this->isTrial,
            ) = unserialize($serialized);
        $this->setId($data[0]);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'userType' => $this->getUserType(),
            'expiry' => $this->getExpiry(),
            'isTrial' => $this->getIsTrial(),
            'mobileNo' => $this->getMobileNo(),
            'userName' => $this->getUsername(),
            'roles' => $this->getRolesAsString(),
            'created' => $this->getCreated() != null ? date_format($this->getCreated(), 'd-m-Y H:i:s') : "",
            'createdBy' => $this->getCreatedBy(),
            'lastUpdatedBy' => $this->getLastUpdBy()
        );
    }
}

