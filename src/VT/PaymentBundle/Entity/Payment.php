<?php

namespace VT\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity(repositoryClass="VT\PaymentBundle\Repository\PaymentRepository")
 */
class Payment extends AbstractVitruEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobileno", type="string", length=20)
     */
    private $mobileNo;

    /**
     * @var string
     *
     * @ORM\Column(name="package", type="string", length=50)
     */
    private $package;

    /**
     * @var string
     *
     * @ORM\Column(name="txn_key", type="string", length=50)
     */
    private $txnKey;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=50)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="txn_id", type="string", length=50)
     */
    private $txnId;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=50)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="string", length=50)
     */
    private $response;

    /**
     *
     * @ORM\OneToOne(targetEntity = "VT\LoginBundle\Entity\Login", fetch="EAGER")
     * @ORM\JoinColumn(name="login_id", referencedColumnName = "row_id")
     *
     */
    private $login;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Payment
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
     * Set email
     *
     * @param string $email
     *
     * @return Payment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobileNo
     *
     * @param string $mobileNo
     *
     * @return Payment
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;

        return $this;
    }

    /**
     * Get mobileNo
     *
     * @return string
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * Set package
     *
     * @param string $package
     *
     * @return Payment
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Payment
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set txnId
     *
     * @param string $txnId
     *
     * @return Payment
     */
    public function setTxnId($txnId)
    {
        $this->txnId = $txnId;

        return $this;
    }

    /**
     * Get txnId
     *
     * @return string
     */
    public function getTxnId()
    {
        return $this->txnId;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set txnKey
     *
     * @param string $txnKey
     *
     * @return Payment
     */
    public function setTxnKey($txnKey)
    {
        $this->txnKey = $txnKey;

        return $this;
    }

    /**
     * Get txnKey
     *
     * @return string
     */
    public function getTxnKey()
    {
        return $this->txnKey;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Payment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set response
     *
     * @param string $response
     *
     * @return Payment
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
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
}

