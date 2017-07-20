<?php
/**
 * Created by PhpStorm.
 * User: harish
 * Date: 02/07/15
 * Time: 14:15
 */

namespace VT\VTCoreBundle\Repository;

class CacheRepository
{
    // different types of caches supported.
    // each one represents on entity type that we want to keep flushable.
    public static $_PRP = "VRRProperty";
    public static $_PRJ = "VRRProject";
    public static $_STATE_LEG = "VRRStateLegacyShared";
    public static $_CITY_LEG = "VRRCityLegacyShared";
    public static $_AREA_LEG = "VRRAreaLegacyShared";
    public static $_ATT = "VAttachment";
    public static $_CLI_DEV = "VRRClient_Developer";
    public static $_KEY_VAL = "VRRKeyValue";
    public static $_WEB_MENU = "VRRWebsiteMenuItem";
    public static $_STP = "VSetup";
    public static $_LOV = "VLstOfVal";

    // default time to live.
    public static $_DEFAULT_TTL = 43200;

    /**
     * @return CacheRepository
     */
    public static function getInstance()
    {
        return Utils::getContainer()->get("vt.cacheRepository");
    }

    public function deleteAll_DoctrineResultCache($type)
    {
        $redisCache = $this->getDoctrineResultCacheDriver($type);
        $deleteAll = $redisCache->deleteAll();
        return $deleteAll;
    }

    /**
     * @param string $type
     * @return \Snc\RedisBundle\Doctrine\Cache\RedisCache
     */
    public function getDoctrineResultCacheDriver($type)
    {
        $redisCache = new \Snc\RedisBundle\Doctrine\Cache\RedisCache();
        $redisCache->setRedis($this->getCacheClient("doctrine"));
        $redisCache->setNamespace(Utils::getAppID() . "_" . $type);
        return $redisCache;
    }

    /**
     * Get the SNC redis cache client. The input parameter is the alias name that we have given to the client while configuring it.
     *
     * @param string $clientName Client alias name
     * @return \Redis
     */
    public function getCacheClient($clientName)
    {
        return Utils::getContainer()->get("snc_redis." . $clientName);
    }
}
