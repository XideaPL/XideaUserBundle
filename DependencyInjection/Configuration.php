<?php

namespace Xidea\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('xidea_user');
        
        $rootNode
            ->children()
                ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('user_factory')->defaultValue('xidea_user.user_factory.default')->end()
                ->scalarNode('user_builder')->defaultValue('xidea_user.user_builder.default')->end()
                ->scalarNode('user_director')->defaultValue('xidea_user.user_director.default')->end()
                ->scalarNode('user_manager')->defaultValue('xidea_user.user_manager.default')->end()
                ->scalarNode('user_loader')->defaultValue('xidea_user.user_loader.default')->end()
            ->end()
        ;

        $this->addCreateSection($rootNode);
        
        //$this->addChangePasswordSection($rootNode);

        return $treeBuilder;
    }
    
    private function addCreateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('create')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('xidea_user_create')->end()
                                ->scalarNode('name')->defaultValue('xidea_user_create_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Create', 'Default'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addChangePasswordSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('change_password')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('xidea_user_change_password')->end()
                                ->scalarNode('name')->defaultValue('xidea_user_change_password_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('change_password'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
