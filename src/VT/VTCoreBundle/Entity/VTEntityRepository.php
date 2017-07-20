<?php
/**
 * Created by PhpStorm.
 * User: Harish Patel
 * Date: 10/20/2014
 * Time: 9:59 AM
 */

namespace VT\VTCoreBundle\Entity;


use Doctrine\ORM\EntityRepository;
use VT\VTCoreBundle\Repository\CacheRepository;

/**
 * Class VTEntityRepository
 * @package VT\VTCoreBundle\Entity
 */
class VTEntityRepository extends EntityRepository
{
    /**
     * @param string $dql
     * @param string $cacheType has to be one of the types specified in CacheRepository::$_PRP_TYPE etc.
     * @return \Doctrine\ORM\Query
     */
    public function createQuery($dql, $cacheType = null)
    {
        return $this->getEntityManager()->createQuery($dql);

        // Redis Cache Switch Off
//        $query = $this->getEntityManager()->createQuery($dql);
//        if (!empty($cacheType)) {
//            $doctrineResultCacheDriver = CacheRepository::getInstance()->getDoctrineResultCacheDriver($cacheType);
//            $query->setResultCacheDriver($doctrineResultCacheDriver);
//            $query->setResultCacheLifetime(CacheRepository::$_DEFAULT_TTL);
//        }
//        return $query;
    }
}
