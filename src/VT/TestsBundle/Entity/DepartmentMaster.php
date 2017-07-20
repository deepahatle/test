<?php

namespace VT\TestsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VT\VTCoreBundle\Entity\AbstractVitruEntity;

/**
 * DepartmentMaster
 *
 * @ORM\Table(name="department_master")
 * @ORM\Entity(repositoryClass="VT\TestsBundle\Repository\DepartmentMasterRepository")
 */
class DepartmentMaster extends AbstractVitruEntity
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;

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
    * Get code
    * @return string 
    */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
    * Set code
    * @return $this
    */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
}

