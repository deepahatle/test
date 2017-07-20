<?php

namespace VT\LabsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;
use VT\VTCoreBundle\Entity\IMultiLabAware;
use VT\VTCoreBundle\Entity\ISoftDeleteAware;

/**
 * LabTest
 *
 * @ORM\Table(name="lab_test")
 * @ORM\Entity(repositoryClass="VT\LabsBundle\Repository\LabTestRepository")
 */
class LabTest extends AbstractVitruEntity implements ISoftDeleteAware, IMultiLabAware, \JsonSerializable
{
    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\TestsBundle\Entity\TestMaster", fetch="EAGER")
     * @ORM\JoinColumn(name="test_id", referencedColumnName = "row_id")
     *
     */
    private $test;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\LabsBundle\Entity\Lab", fetch="EAGER")
     * @ORM\JoinColumn(name="lab_id", referencedColumnName = "row_id")
     *
     */
    private $lab;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="string")
     */
    private $cost;

    /**
    * Get test
    * @return mixed 
    */
    public function getTest()
    {
        return $this->test;
    }
    
    /**
    * Set test
    * @return $this
    */
    public function setTest($test)
    {
        $this->test = $test;
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

    /**
    * Get cost
    * @return string 
    */
    public function getCost()
    {
        return $this->cost;
    }
    
    /**
    * Set cost
    * @return $this
    */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
    * Get testName from TestMaster
    * @return string 
    */
    public function getTestName()
    {
        return $this->getTest()->getName();
    }

    /**
    * Get testName from TestMaster
    * @return string 
    */
    public function getDepartmentName()
    {
        return $this->getTest()->getDepartment()->getName();
    }

    function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "test" => $this->getTestName(),
            "department" => $this->getDepartmentName(),
            "cost" => $this->getCost()
        );
    }
}

