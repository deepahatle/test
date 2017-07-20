<?php
/**
 * Created by PhpStorm.
 * User: harish
 * Date: 18/05/16
 * Time: 14:18
 */

namespace VT\VTCoreBundle\Services\Acl;

use VT\VTCoreBundle\Services\Utils;
use VT\VTCoreBundle\Services\Doctrine\VTEntityManager;

/**
 *
 * This class acts a container of all the access control lists configured on a per bundle basis in the container.
 *
 * The list of acls that this class has are populated using a compiler pass and are done only once when the cache is cleared.
 *
 * As a convention all methods starting with a "_" underscore in this class are returning the global values of that particular
 * attribute, be it a list of all acls available or a possible list of roles in the container.
 *
 * Class ACLManager
 * @package VT\VTCoreBundle\Services\Acl
 */
class ACLManager
{
    private $acls;

    public function __construct()
    {
        $this->acls = array();
    }

    /**
     * @param $acl IACL
     */
    public function _addACL($acl)
    {
        $this->acls[$acl->getBundleName()] = $acl;
    }

    /**
     * @return array
     */
    public function _globalAcls()
    {
        return $this->acls;
    }

    /**
     * @return array
     */
    public function _globalRoles()
    {
        return array(
            IACL::ROLE_END_USER => IACL::ROLE_END_USER,
            IACL::ROLE_ADMIN => IACL::ROLE_ADMIN,
            IACL::ROLE_DATA_ENTRY => IACL::ROLE_DATA_ENTRY,
            IACL::ROLE_REGISTRAR => IACL::ROLE_REGISTRAR,
            IACL::ROLE_EXECUTIVE => IACL::ROLE_EXECUTIVE,
            IACL::ROLE_PROFESSIONAL => IACL::ROLE_PROFESSIONAL
        );
    }

    /**
     *
     * All acls linked to the specified role name are returned in an array.
     *
     * @param $roleName string The role name against which globally how many acls are present will be returned.
     * @return array
     *
     */
    public function _globalAclsForRole($roleName)
    {
        $finalArray = array();
        foreach ($this->_globalAcls() as $bundleName => $aclsForBundle) {
            $t = $aclsForBundle->getAclsForRole($roleName);
            if (!empty($t))
                $finalArray[] = $t;
        }
        return $finalArray;
    }

    /**
     *
     * Determines if the currently logged in user has access to perform the specified action on the specified module name.
     *
     * @param $bundleName string The bundle on which we have to check for the access.
     * @param $moduleName string The module on which we have to check for the access.
     * @param $actionName string The action that is to be checked.
     *
     * @return boolean Whether the currently logged in user has access to the given action on the specified bundle and module.
     *
     */
    public function hasAccess($bundleName, $moduleName, $actionName)
    {
        $user = $this->getUser();
        if (isset($user)) {
            $roles = $user->getRoles();
            if (!empty($roles)) {
                $acls = $this->_globalAcls();
                $bundleACLs = Utils::blankIfNull($acls, $bundleName);
                if (!empty($bundleACLs)) {
                    $moduleACLs = Utils::blankIfNull($bundleACLs->getAcl(), $moduleName);
                    if (!empty($moduleACLs)) {
                        $allowedToRoles = Utils::blankIfNull($moduleACLs, $actionName);
                        $intersection = array_intersect($roles, $allowedToRoles);
                        return !empty($intersection);
                    }
                }
            }
        }

        return false;
    }

    /**
     *
     * Returns the currently logged in user.
     *
     * @return \VT\LoginBundle\Entity\Login
     *
     */
    public function getUser()
    {
        $container = Utils::getContainer();

        if (!$container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        $user = VTEntityManager::getInstance()->getEntityManager(array())->getRepository("LoginBundle:Login")->find($user->getId());

        return $user;

    }

}
