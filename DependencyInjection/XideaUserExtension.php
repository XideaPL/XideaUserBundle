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
        $loader->load('form.yml');
        $loader->load('controller.yml');
        $loader->load('twig.yml');

        $this->loadUserSection($config['user'], $container, $loader);
    }
    
    private function loadUserSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_user.user.class', $config['class']);
        $container->setAlias('xidea_user.user_factory', $config['factory']);
        $container->setAlias('xidea_user.user_builder', $config['builder']);
        $container->setAlias('xidea_user.user_director', $config['director']);
        $container->setAlias('xidea_user.user_manager', $config['manager']);
        $container->setAlias('xidea_user.user_loader', $config['loader']);
        
         if (!empty($config['create'])) {
            $this->loadUserCreateSection($config['create'], $container, $loader);
        }
    }
    
    private function loadUserCreateSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_user.user_create.form.type', $config['form']['type']);
        $container->setParameter('xidea_user.user_create.form.name', $config['form']['name']);
        $container->setParameter('xidea_user.user_create.form.validation_groups', $config['form']['validation_groups']);
    }
}
