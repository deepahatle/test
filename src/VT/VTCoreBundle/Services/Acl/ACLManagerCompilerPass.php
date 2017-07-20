<?php
/**
 * Created by PhpStorm.
 * User: harish
 * Date: 18/05/16
 * Time: 14:23
 */

namespace VT\VTCoreBundle\Services\Acl;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 * Please note that the compiler pass is invoked only when the container is initiliazed, this happens
 * only when the case is being created in the background.
 *
 * So to debug issues around this not getting invoked please note that you might have to delete the var/cache folder
 * once you delete you can put a debug point here and expect the flow to get stuck, other wise this is never invoked.
 *
 * Class ACLManagerCompilerPass
 * @package VT\VTCoreBundle\Services\Acl
 */
class ACLManagerCompilerPass implements CompilerPassInterface
{
    /**
     * Used specifically during container startup to populate the ACLManager class
     * with all available access control lists configured in the Symfony service container.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('vt.aclmanager')) {
            return;
        }

        $aclmanager = $container->findDefinition('vt.aclmanager');

        $aclDefinitions = $container->findTaggedServiceIds('acl');
        foreach ($aclDefinitions as $id => $tags) {
            $aclmanager->addMethodCall('_addACL', array(new Reference($id)));
        }
    }

}
