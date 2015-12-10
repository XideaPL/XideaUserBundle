<?php

namespace Xidea\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerBuilder;

use Xidea\Bundle\BaseBundle\AbstractBundle;

class XideaUserBundle extends AbstractBundle
{    
    protected function getModelNamespace()
    {
        return 'Xidea\User';
    }
}
