<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/06/17
 * Time: 10:31 AM
 */

namespace VT\GeneralBundle\Form\Model;


class ContactUs
{
    private $name;
    private $phoneNumber;
    private $emailId;
    private $message;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContactUs
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return ContactUs
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailId()
    {
        return $this->emailId;
    }

    /**
     * @param string $emailId
     * @return ContactUs
     */
    public function setEmailId($emailId)
    {
        $this->emailId = $emailId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ContactUs
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


}