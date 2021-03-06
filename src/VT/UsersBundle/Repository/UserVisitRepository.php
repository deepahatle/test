<?php

namespace VT\UsersBundle\Repository;
use VT\VTCoreBundle\Entity\VTEntityRepository;

/**
 * UserVisitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserVisitRepository extends VTEntityRepository
{
	/**
     * @param array $fullSpec
     * @param boolean $countOnly
     * @return array
     */
    public function fetchPatientsByFilter($fullSpec, $countOnly = false)
    {

        $searchSpec = isset($fullSpec['searchSpec']) ? $fullSpec['searchSpec'] : "";
        $sortSpec = isset($fullSpec['sortSpec']) ? $fullSpec['sortSpec'] : "";
        $pageSpec = isset($fullSpec['pageSpec']) ? $fullSpec['pageSpec'] : "";

        $extraQ = "";
        $extraQ .= "";

        if(!empty($searchSpec)) {
            if (array_key_exists('keyword', $searchSpec)) {
                $k = $searchSpec['keyword'];
                if (!empty($k)) {
                    if (!empty($extraQ))
                        $extraQ .= " and ";
                    $extraQ .= "(us.name like '%" . $k . "%' )";
                }
            }
        }

        $cq = "";
        $cq .= "select count(distinct u.id) ";
        $cq .= "from UsersBundle:UserVisit as u ";
        $cq .= "left join u.user as us ";
        if (!empty($extraQ)) {
            $cq .= "where " . $extraQ;
        }

        $q = "";
        if (!$countOnly) {
            $q .= "select u ";
            $q .= "from UsersBundle:UserVisit as u ";
            $q .= "left join u.user as us ";
            if (!empty($extraQ)) {
                $q .= "where " . $extraQ;
            }
        }

        $q .= " ORDER BY u.created desc ";

        // Total Count
        $tql = $this->createQuery($cq);
        $totalRecords = $tql->getResult();

        // doctors
        $doctors = array();
        if (!$countOnly) {
            $dql = $this->createQuery($q);
            if (!empty($pageSpec) && $pageSpec['pageSize'] != "") {
                $dql->setMaxResults($pageSpec['pageSize'])->setFirstResult(($pageSpec['currentPage'] - 1) * $pageSpec['pageSize']);
            }
            $doctors = $dql->getResult();
            return array("totalRecords" => $totalRecords, "patients" => $doctors);
        } else {
            return array("totalRecords" => $totalRecords[0][1]);
        }
    }

    public function fetchPatientsByPendingPayments(){
        $q = " select u from UsersBundle:UserVisit as u ";
        $q .= " where u.netAmount != u.paidAmount ";
        $q .= " ORDER BY u.created asc ";
        $dql = $this->createQuery($q);
        $records = $dql->setMaxResults(10)->getResult();
        return $records;
    }

    public function fetchPatientsBySamplesUnderTesting(){
        $q = " select u from UsersBundle:UserVisit as u ";
        $q .= " where u.status = 'Sample under testing' ";
        $q .= " ORDER BY u.created desc ";

        $dql = $this->createQuery($q);

        $records = $dql->getResult();
        return $records;
    }
}
