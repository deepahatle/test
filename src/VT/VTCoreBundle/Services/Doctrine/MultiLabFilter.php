<?php

namespace VT\VTCoreBundle\Services\Doctrine;


use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use VT\VTCoreBundle\Services\Utils;

class MultiLabFilter extends SQLFilter implements IFilterConfigurer
{
    public static $filterName = "MultiLabFilter";

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface('\VT\VTCoreBundle\Entity\IMultiLabAware')) {
            return "";
        }

        return $targetTableAlias . ".lab_id = '" . trim($this->getParameter("labID"), "'") . "'";
    }

    public function configureFilter()
    {
        $this->setParameter('labID', Utils::getLabID());
    }
}