<?php

namespace VT\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * UserVisitTests
 *
 * @ORM\Table(name="user_visit_tests")
 * @ORM\Entity(repositoryClass="VT\UsersBundle\Repository\UserVisitTestsRepository")
 */
class UserVisitTests extends AbstractVitruEntity implements \JsonSerializable
{
    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\UsersBundle\Entity\UserVisit", fetch="EAGER", cascade={"persist"})
     * @ORM\JoinColumn(name="user_visit_id", referencedColumnName = "row_id")
     *
     */
    private $userVisit;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\LabsBundle\Entity\LabTest", fetch="EAGER")
     * @ORM\JoinColumn(name="lab_test_id", referencedColumnName = "row_id")
     *
     */
    private $labTest;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="actual_value", type="string")
     */
    private $actualValue;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="comments", type="string")
     */
    private $comments;

    /**
    * Get userVisit
    * @return mixed 
    */
    public function getUserVisit()
    {
        return $this->userVisit;
    }
    
    /**
    * Set userVisit
    * @return $this
    */
    public function setUserVisit($userVisit)
    {
        $this->userVisit = $userVisit;
        return $this;
    }

    /**
    * Get labTest
    * @return mixed 
    */
    public function getLabTest()
    {
        return $this->labTest;
    }
    
    /**
    * Set labTest
    * @return $this
    */
    public function setLabTest($labTest)
    {
        $this->labTest = $labTest;
        return $this;
    }

    /**
    * Get actualValue
    * @return string 
    */
    public function getActualValue()
    {
        return $this->actualValue;
    }
    
    /**
    * Set actualValue
    * @return $this
    */
    public function setActualValue($actualValue)
    {
        $this->actualValue = $actualValue;
        return $this;
    }

    /**
    * Get comments
    * @return string 
    */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
    * Set comments
    * @return $this
    */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    function jsonSerialize(){
        $dateTime = $this->getCreated();
        $date = $dateTime->format('Y, m, d');
        $dob = $this->getUserVisit()->getUser()->getDob();
        $age = $dob->diff(new \DateTime('today'))->y;
        $gender = $this->getUserVisit()->getUser()->getGender();
        if($age < 18){
            $lowerValue = $this->getLabTest()->getTest()->getLowerValueChild();
            $higherValue = $this->getLabTest()->getTest()->getHigherValueChild();
        }
        else{
            if($gender == 'm'){
                $lowerValue = $this->getLabTest()->getTest()->getLowerValueMale();
                $higherValue = $this->getLabTest()->getTest()->getHigherValueMale();
            }
            else{
                $lowerValue = $this->getLabTest()->getTest()->getLowerValueFemale();
                $higherValue = $this->getLabTest()->getTest()->getHigherValueFemale();
            }
        }

        return array(
            'id' => $this->getId(),
            'name' => $this->getLabTest()->getTestName(),
            'actualValue' => $this->getActualValue(),
            'date' => $date,
            'unit' => $this->getLabTest()->getTest()->getUnit(),
            'comments' => $this->getComments(),
            'lowerValue' => $lowerValue,
            'higherValue' => $higherValue,
            'labName' => $this->getUserVisit()->getLab()->getName()
        );  
    }
}