<?php

namespace VT\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * PayuWalletAuth
 *
 * @ORM\Table(name="payu_wallet_auth")
 * @ORM\Entity(repositoryClass="VT\PaymentBundle\Repository\PayuWalletAuthRepository")
 */
class PayuWalletAuth extends AbstractVitruEntity
{    
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
    private $mobileno;

    /**
     * @var string
     *
     * @ORM\Column(name="auth_token", type="string", length=100)
     */
    private $authToken;

    /**
     * @var string
     *
     * @ORM\Column(name="refresh_token", type="string", length=100)
     */
    private $refreshToken;

    /**
     * @var string
     *
     * @ORM\Column(name="token_type", type="string", length=100)
     */
    private $tokenType;

    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=100)
     */
    private $scope;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     *
     * @ORM\OneToOne(targetEntity = "VT\LoginBundle\Entity\Login", fetch="EAGER")
     * @ORM\JoinColumn(name="login_id", referencedColumnName = "row_id")
     *
     */
    private $login;

    /**
     * Set email
     *
     * @param string $email
     *
     * @return PayuWalletAuth
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
     * Set mobileno
     *
     * @param string $mobileno
     *
     * @return PayuWalletAuth
     */
    public function setMobileno($mobileno)
    {
        $this->mobileno = $mobileno;

        return $this;
    }

    /**
     * Get mobileno
     *
     * @return string
     */
    public function getMobileno()
    {
        return $this->mobileno;
    }

    /**
     * Set authToken
     *
     * @param string $authToken
     *
     * @return PayuWalletAuth
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Get authToken
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Set refreshToken
     *
     * @param string $refreshToken
     *
     * @return PayuWalletAuth
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get refreshToken
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set tokenType
     *
     * @param string $tokenType
     *
     * @return PayuWalletAuth
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;

        return $this;
    }

    /**
     * Get tokenType
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Set scope
     *
     * @param string $scope
     *
     * @return PayuWalletAuth
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return PayuWalletAuth
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
     * Set login
     *
     * @param string mixed
     *
     * @return PayuWalletAuth
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }
}

