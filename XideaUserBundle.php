<?php

namespace Xidea\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerBuilder;

use Xidea\Bundle\BaseBundle\AbstractBundle;

class XideaUserBundle extends AbstractBundle
{
    protected function getModelMappings()
    {
        return array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Xidea\Component\User\Model',
        );
    }
}
