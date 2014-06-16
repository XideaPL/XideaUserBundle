<?php

namespace Xidea\Bundle\UserBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ChangePasswordExtension extends \Twig_Extension
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'xidea_user_change_password_enabled' => new \Twig_Function_Method($this, 'isChangePasswordEnabled', array('is_safe' => array('html')))
        );
    }

    public function getName()
    {
        return 'xidea_user_change_password';
    }

    public function isChangePasswordEnabled()
    {
        return $this->container->getParameter('xidea_user.change_password.enabled');
    }

}
