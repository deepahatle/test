<?php

namespace VT\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\LabsBundle\Entity\Lab;
use VT\VTCoreBundle\Entity\IMultiLabAware;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * UserVisit
 *
 * @ORM\Table(name="user_visit")
 * @ORM\Entity(repositoryClass="VT\UsersBundle\Repository\UserVisitRepository")
 */
class UserVisit extends AbstractVitruEntity implements IMultiLabAware, \JsonSerializable
{
    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\LabsBundle\Entity\Lab", fetch="EAGER")
     * @ORM\JoinColumn(name="lab_id", referencedColumnName = "row_id")
     *
     */
    private $lab;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\UsersBundle\Entity\User", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName = "row_id")
     *
     */
    private $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\UsersBundle\Entity\Doctor", fetch="EAGER")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName = "row_id")
     *
     */
    private $doctor;

    // *
    //  *
    //  * @ORM\ManyToOne(targetEntity = "VT\UsersBundle\Entity\TaxMaster", fetch="EAGER", cascade={"persist"})
    //  * @ORM\JoinColumn(name="tax_id", referencedColumnName = "row_id")
    //  *
     
    // private $tax;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_amount", type="string")
     */
    private $totalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount", type="string")
     */
    private $discount;

    /**
     * @var integer
     *
     * @ORM\Column(name="net_amount", type="string")
     */
    private $netAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="paid_amount", type="string")
     */
    private $paidAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="enable_view_for_user", type="string")
     */
    private $enableViewForUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    /**
    * Get lab
    * @return Lab
    */
    public function getLab()
    {
        return $this->lab;
    }

    /**
     * Set lab
     * @param $lab
     * @return $this
     */
    public function setLab($lab)
    {
        $this->lab = $lab;
        return $this;
    }

    /**
    * Get user
    * @return User
    */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
    * Get doctor
    * @return Doctor
    */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Set doctor
     * @param $doctor
     * @return $this
     */
    public function setDoctor($doctor)
    {
        $this->doctor = $doctor;
        return $this;
    }

    // /**
    // * Get tax
    // * @return mixed 
    // */
    // public function getTax()
    // {
    //     return $this->tax;
    // }
    
    // *
    // * Set tax
    // * @return $this
    
    // public function setTax($tax)
    // {
    //     $this->tax = $tax;
    //     return $this;
    // }

    /**
    * Get totalAmount
    * @return string 
    */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    
    /**
    * Set totalAmount
    * @return $this
    */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
    * Get discount
    * @return string 
    */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
    * Set discount
    * @return $this
    */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
    * Get netAmount
    * @return string 
    */
    public function getNetAmount()
    {
        return $this->netAmount;
    }
    
    /**
    * Set netAmount
    * @return $this
    */
    public function setNetAmount($netAmount)
    {
        $this->netAmount = $netAmount;
        return $this;
    }

    /**
    * Get paidAmount
    * @return string 
    */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }
    
    /**
    * Set paidAmount
    * @return $this
    */
    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

    /**
    * Get enableViewForUser
    * @return string 
    */
    public function getEnableViewForUser()
    {
        return $this->enableViewForUser;
    }
    
    /**
    * Set enableViewForUser
    * @return $this
    */
    public function setEnableViewForUser($enableViewForUser)
    {
        $this->enableViewForUser = $enableViewForUser;
        return $this;
    }

    /**
    * Get status
    * @return string 
    */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
    * Set status
    * @return $this
    */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    function jsonSerialize(){
        $dateTime = $this->getCreated();
        $date = $dateTime->format('d/m/Y');
        $time = $dateTime->format('H:i');
        $dob = $this->getUser()->getDob();
        $age = $dob->diff(new \DateTime())->y;
        return array(
            "id" => $this->getId(),
            "name" => $this->getUser()->getName(),
            "mobile" => $this->getUser()->getMobile(),
            "email" => $this->getUser()->getEmail(),
            "address" => $this->getUser()->getAddress(),
            "city" => $this->getUser()->getCity(),
            "gender" => $this->getUser()->getGender(),
            "age" => $age,
            "date" => $date,
            "time" => $time,
            "netAmount" => $this->getNetAmount(),
            "paidAmount" =>$this->getPaidAmount(),
            "doctor" =>$this->getDoctor()->getName(),
            "lab" =>$this->getLab()->getName(),
            "status" =>$this->getStatus(),
            "enableViewForUser" =>$this->getEnableViewForUser()
        );
    }
}

