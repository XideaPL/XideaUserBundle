<?php

namespace Xidea\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public function __construct($alias)
    {
        parent::__construct($alias);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = parent::getConfigTreeBuilder();
        $rootNode = $treeBuilder->root($this->alias);

        $this->addUserSection($rootNode);
        $this->addProfileSection($rootNode);
        $this->addTemplateSection($rootNode);

        return $treeBuilder;
    }
    
    public function getDefaultTemplateNamespace()
    {
        return '@XideaUser';
    }
    
    protected function addUserSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('code')->defaultValue('xidea_user')->end()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_user.user.factory.default')->end()
                        ->scalarNode('builder')->defaultValue('xidea_user.user.builder.default')->end()
                        ->scalarNode('director')->defaultValue('xidea_user.user.director.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_user.user.manager.default')->end()
                        ->scalarNode('loader')->defaultValue('xidea_user.user.loader.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->arrayNode('create')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('factory')->defaultValue('xidea_user.user.form.create.factory.default')->end()
                                        ->scalarNode('handler')->defaultValue('xidea_user.user.form.create.handler.default')->end()
                                        ->scalarNode('type')->defaultValue('xidea_user.create')->end()
                                        ->scalarNode('name')->defaultValue('xidea_user.create_form')->end()
                                        ->arrayNode('validation_groups')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(array('Create', 'Default'))
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    protected function addProfileSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('profile')
                    ->canBeEnabled()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('code')->defaultValue('xidea_profile')->end()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_user.profile.factory.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_user.profile.manager.default')->end()
                    ->end()
                ->end()
            ->end();
    }
    
    protected function addTemplateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->append($this->addTemplateNode($this->getDefaultTemplateNamespace(), $this->getDefaultTemplateEngine(), [], true))
            ->end();
    }
}
