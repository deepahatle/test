<?php
/**
 * Created by PhpStorm.
 * User: harish
 * Date: 18/05/16
 * Time: 11:46
 */

namespace VT\VTCoreBundle\Services\Acl;

interface IACL extends \JsonSerializable
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_DATA_ENTRY = "ROLE_DATA_ENTRY";
    const ROLE_REGISTRAR = "ROLE_REGISTRAR";
    const ROLE_EXECUTIVE = "ROLE_EXECUTIVE";
    const ROLE_PROFESSIONAL = "ROLE_PROFESSIONAL";
    const ROLE_END_USER = "ROLE_USER";

    public function getBundleName();

    public function getACL();

    public function actionExists($moduleName, $actionName);
}
