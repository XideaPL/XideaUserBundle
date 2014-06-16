<?php

namespace Xidea\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaUserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('user.yml');
        $loader->load('user_orm.yml');
        $loader->load('security.yml');
        $loader->load('profile.yml');
        $loader->load('change_password.yml');
        $loader->load('twig.yml');

        $container->setParameter('xidea_user.user.class', $config['user_class']);
        $container->setAlias('xidea_user.user_factory', $config['user_factory']);
        $container->setAlias('xidea_user.user_manager', $config['user_manager']);
        $container->setAlias('xidea_user.user_loader', $config['user_loader']);
        
        if (!empty($config['registration'])) {
            $this->loadRegistration($config['registration'], $container, $loader);
        }
        
        if (!empty($config['change_password'])) {
            $this->loadChangePassword($config['change_password'], $container, $loader);
        }
    }
    
    private function loadRegistration(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $loader->load('registration.yml');
        
        $container->setParameter('xidea_user.registration.form.type', $config['form']['type']);
        $container->setParameter('xidea_user.registration.form.name', $config['form']['name']);
        $container->setParameter('xidea_user.registration.form.validation_groups', $config['form']['validation_groups']);
    }
    
    private function loadChangePassword(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $loader->load('change_password.yml');
        
        $container->setParameter('xidea_user.change_password.enabled', $config['enabled']);
        $container->setParameter('xidea_user.change_password.form.type', $config['form']['type']);
        $container->setParameter('xidea_user.change_password.form.name', $config['form']['name']);
        $container->setParameter('xidea_user.change_password.form.validation_groups', $config['form']['validation_groups']);
    }
}
