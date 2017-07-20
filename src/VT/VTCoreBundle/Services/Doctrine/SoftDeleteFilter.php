<?php

namespace VT\VTCoreBundle\Services\Doctrine;


use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SoftDeleteFilter extends SQLFilter implements IFilterConfigurer
{
    public static $filterName = "SoftDeleteFilter";

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface('\VT\VTCoreBundle\Entity\ISoftDeleteAware')) {
            return "";
        }

        return $targetTableAlias . ".DELETED = 0";
    }

    public function configureFilter()
    {
        // Nothing to do here.
    }
}