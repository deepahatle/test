<?php

namespace VT\VTCoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use VT\VTCoreBundle\Services\Acl\ACLManagerCompilerPass;

class VTCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ACLManagerCompilerPass());
    }

}
