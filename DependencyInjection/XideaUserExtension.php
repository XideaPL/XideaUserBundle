<?php

namespace Xidea\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaUserExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config, $loader) = $this->setUp($configs, new Configuration($this->getAlias()), $container);

        $loader->load('user.yml');
        $loader->load('user_orm.yml');
        $loader->load('security.yml');
        $loader->load('form.yml');
        $loader->load('controller.yml');
        $loader->load('template.yml');
        $loader->load('twig.yml');
        
        $this->loadUserSection($config['user'], $container, $loader);
        $this->loadProfileSection($config['profile'], $container, $loader);
        
        if (isset($config['template'])) {
            $this->loadTemplateSection($this->getAlias(), $config['template'], $container, $loader);
        }
    }
    
    protected function loadUserSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_user.user.code', $config['code']);
        $container->setParameter('xidea_user.user.class', $config['class']);
        $container->setAlias('xidea_user.user.configuration', $config['configuration']);
        $container->setAlias('xidea_user.user.factory', $config['factory']);
        $container->setAlias('xidea_user.user.builder', $config['builder']);
        $container->setAlias('xidea_user.user.director', $config['director']);
        $container->setAlias('xidea_user.user.manager', $config['manager']);
        $container->setAlias('xidea_user.user.loader', $config['loader']);
        
        if (!empty($config['form'])) {
            $this->loadUserFormSection($config['form'], $container, $loader);
        }
    }
    
    protected function loadUserFormSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setAlias('xidea_user.user.form.create.factory', $config['create']['factory']);
        $container->setAlias('xidea_user.user.form.create.handler', $config['create']['handler']);
        
        $container->setParameter('xidea_user.user.form.create.type', $config['create']['type']);
        $container->setParameter('xidea_user.user.form.create.name', $config['create']['name']);
        $container->setParameter('xidea_user.user.form.create.validation_groups', $config['create']['validation_groups']);
    }
    
    protected function loadProfileSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_user.profile.enabled', $config['enabled']);
        
        if(!$config['enabled']) {
            return false;
        }
            
        $loader->load('profile.yml');
        $loader->load('profile_orm.yml');
        $loader->load('profile_controller.yml');

        $container->setParameter('xidea_user.profile.code', $config['code']);
        $container->setParameter('xidea_user.profile.class', $config['class']);
        $container->setAlias('xidea_user.profile.configuration', $config['configuration']);
        $container->setAlias('xidea_user.profile.factory', $config['factory']);
        $container->setAlias('xidea_user.profile.manager', $config['manager']);
    }
    
    protected function getConfigurationDirectory()
    {
        return __DIR__.'/../Resources/config';
    }
    
    protected function getDefaultTemplates()
    {
        return [
            'main' => ['namespace' => '', 'path' => 'main'],
            'login_main' => ['path' => 'main'],
            'login' => ['path' => 'Security/login'],
            'login_form' => ['path' => 'Security/login_form'],
            'user_main' => ['path' => 'main'],
            'user_list' => ['path' => 'User/List/list'],
            'user_show' => ['path' => 'User/Show/show'],
            'user_create' => ['path' => 'User/Create/create'],
            'user_create_form' => ['path' => 'User/Main/form'],
            'profile_main' => ['path' => 'main'],
            'profile_show' => ['path' => 'Profile/Show/show']
        ];
    }
}
