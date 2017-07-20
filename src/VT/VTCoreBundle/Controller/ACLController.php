<?php
/**
 * Created by PhpStorm.
 * User: harish
 * Date: 18/05/16
 * Time: 14:31
 */

namespace VT\VTCoreBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use VT\VTCoreBundle\Services\Utils;

class ACLController extends VTController
{
    /**
     *
     * @Route("/acl/globalAcls", name="acl_globalAcls")
     * @return Response
     *
     */
    public function globalAcls()
    {
        $aclManager = $this->get("vt.aclmanager");

        // see if we have details of the logged in user.
        $user = Utils::getContainer()->get("vt.aclmanager")->getUser();
        $user->getUsername();

        $r = array(
            "user" => $user,
            "acls" => $aclManager->_globalAcls()
        );

        return $this->getJsonResponse(json_encode($r));
    }

    /**
     *
     * @Route("/acl/globalAclsForRole/{roleName}", name="acl_globalAclsForRole")
     * @param $roleName string
     * @return Response
     *
     */
    public function globalAclsForRole($roleName)
    {
        $aclManager = $this->get("vt.aclmanager");

        return $this->getJsonResponse(json_encode($aclManager->_globalAclsForRole($roleName)));
    }

}
