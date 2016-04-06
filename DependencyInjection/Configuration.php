<?php

namespace Xidea\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Xidea\Bundle\BaseBundle\DependencyInjection\Helper\ConfigurationHelper;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /*
     * @var string
     */
    protected $alias;
    
    public function __construct($alias)
    {
        $this->alias = $alias;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->getAlias());

        
        $this->addUserSection($rootNode);
        $this->addRoleSection($rootNode);
        $this->addProfileSection($rootNode);
        
        $helper = new ConfigurationHelper($this->getAlias());
        $helper->addTemplateSection($rootNode);

        return $treeBuilder;
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
                                ->arrayNode('user')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('factory')->defaultValue('xidea_user.user.form.factory.default')->end()
                                        ->scalarNode('handler')->defaultValue('xidea_user.user.form.handler.default')->end()
                                        ->scalarNode('type')->defaultValue('Xidea\Bundle\UserBundle\Form\Type\UserType')->end()
                                        ->scalarNode('name')->defaultValue('user')->end()
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
    
    protected function addRoleSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('role')
                    ->canBeEnabled()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('code')->defaultValue('xidea_role')->end()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_user.role.factory.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_user.role.manager.default')->end()
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
}
