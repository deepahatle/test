<?php

namespace VT\TestsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * TestMaster
 *
 * @ORM\Table(name="test_master")
 * @ORM\Entity(repositoryClass="VT\TestsBundle\Repository\TestMasterRepository")
 */
class TestMaster extends AbstractVitruEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "VT\TestsBundle\Entity\DepartmentMaster", fetch="EAGER")
     * @ORM\JoinColumn(name="department_id", referencedColumnName = "row_id")
     *
     */
    private $department;

    /**
     * @var integer
     *
     * @ORM\Column(name="default_cost", type="string")
     */
    private $defaultCost;

    /**
     * @var integer
     *
     * @ORM\Column(name="lower_value_male", type="string")
     */
    private $lowerValueMale;

    /**
     * @var integer
     *
     * @ORM\Column(name="higher_value_male", type="string")
     */
    private $higherValueMale;

    /**
     * @var integer
     *
     * @ORM\Column(name="lower_value_female", type="string")
     */
    private $lowerValueFemale;

    /**
     * @var integer
     *
     * @ORM\Column(name="higher_value_female", type="string")
     */
    private $higherValueFemale;

    /**
     * @var integer
     *
     * @ORM\Column(name="lower_value_child", type="string")
     */
    private $lowerValueChild;

    /**
     * @var integer
     *
     * @ORM\Column(name="higher_value_child", type="string")
     */
    private $higherValueChild;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string")
     */
    private $unit;

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
    * Get department
    * @return string 
    */
    public function getDepartment()
    {
        return $this->department;
    }
    
    /**
    * Set department
    * @return $this
    */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
    * Get defaultCost
    * @return string 
    */
    public function getDefaultCost()
    {
        return $this->defaultCost;
    }
    
    /**
    * Set defaultCost
    * @return $this
    */
    public function setDefaultCost($defaultCost)
    {
        $this->defaultCost = $defaultCost;
        return $this;
    }

    /**
    * Get lowerValueMale
    * @return string 
    */
    public function getLowerValueMale()
    {
        return $this->lowerValueMale;
    }
    
    /**
    * Set lowerValueMale
    * @return $this
    */
    public function setLowerValueMale($lowerValueMale)
    {
        $this->lowerValueMale = $lowerValueMale;
        return $this;
    }

    /**
    * Get higherValueMale
    * @return  
    */
    public function getHigherValueMale()
    {
        return $this->higherValueMale;
    }
    
    /**
    * Set higherValueMale
    * @return $this
    */
    public function setHigherValueMale($higherValueMale)
    {
        $this->higherValueMale = $higherValueMale;
        return $this;
    }

    /**
    * Get lowerValueFemale
    * @return string 
    */
    public function getLowerValueFemale()
    {
        return $this->lowerValueFemale;
    }
    
    /**
    * Set lowerValueFemale
    * @return $this
    */
    public function setLowerValueFemale($lowerValueFemale)
    {
        $this->lowerValueFemale = $lowerValueFemale;
        return $this;
    }

    /**
    * Get higherValueFemale
    * @return  
    */
    public function getHigherValueFemale()
    {
        return $this->higherValueFemale;
    }
    
    /**
    * Set higherValueFemale
    * @return $this
    */
    public function setHigherValueFemale($higherValueFemale)
    {
        $this->higherValueFemale = $higherValueFemale;
        return $this;
    }

    /**
    * Get lowerValueChild
    * @return string 
    */
    public function getLowerValueChild()
    {
        return $this->lowerValueChild;
    }
    
    /**
    * Set lowerValueChild
    * @return $this
    */
    public function setLowerValueChild($lowerValueChild)
    {
        $this->lowerValueChild = $lowerValueChild;
        return $this;
    }

    /**
    * Get higherValueChild
    * @return  
    */
    public function getHigherValueChild()
    {
        return $this->higherValueChild;
    }
    
    /**
    * Set higherValueChild
    * @return $this
    */
    public function setHigherValueChild($higherValueChild)
    {
        $this->higherValueChild = $higherValueChild;
        return $this;
    }

    /**
    * Get unit
    * @return string 
    */
    public function getUnit()
    {
        return $this->unit;
    }
    
    /**
    * Set unit
    * @return $this
    */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }
}

