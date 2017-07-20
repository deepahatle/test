<?php

namespace VT\VTCoreBundle\Services\Doctrine;

use Doctrine\ORM\EntityManager;
use VT\VTCoreBundle\Services\Utils;

class VTEntityManager
{
    private $em;
    private $filterNames = array();

    public static function getInstance()
    {
        return Utils::getContainer()->get("vt.entityManager");
    }

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        // when constructing instances of this class we also initialize all the filters required.
        $configuration = $this->em->getConfiguration();

        // ----------------------------------------------------
        // all the supported filters.
        // ----------------------------------------------------
        // add the soft delete filter to the list.
        $this->filterNames[] = SoftDeleteFilter::$filterName;
        $configuration->addFilter(SoftDeleteFilter::$filterName, "\VT\VTCoreBundle\Services\Doctrine\SoftDeleteFilter");

        $this->filterNames[] = MultiLabFilter::$filterName;
        $configuration->addFilter(MultiLabFilter::$filterName, "\VT\VTCoreBundle\Services\Doctrine\MultiLabFilter");

        // ----------------------------------------------------
        // all supported functions.
        // ----------------------------------------------------
        $configuration->addCustomStringFunction("YEAR", "\VT\VTCoreBundle\Services\Doctrine\Functions\YearFunction");
    }

    public function getEntityManager($filtersToEnable = array())
    {
        $filterCollection = $this->em->getFilters();

        // ------------------------------
        // disable all the filters.
        // ------------------------------
        foreach ($this->filterNames as $idx => $filterName) {
            if ($filterCollection->isEnabled($filterName)) {
                $filterCollection->disable($filterName);
            }
        }

        // ------------------------------
        // enable only the ones we have for this transaction.
        // ------------------------------
        if (empty($filtersToEnable)) {
            // if no filters have been specified to be enabled, then we enable all by default.
            $filtersToEnable = $this->filterNames;
        }

        // now enable the required filters.
        foreach ($filtersToEnable as $idx => $filterToEnable) {
            $filter = $filterCollection->enable($filterToEnable);
            if (!empty($filter)) {
                $filter->configureFilter();
            }
        }

        return $this->em;
    }
}
