<?php

namespace RodrigoRigotti\Bundle\CVBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    private $validLanguages      = array('php', 'js');
    private $validLanguageLevels = array('basic', 'intermediate', 'advanced', 'fluent', 'native');
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rodrigo_rigotti_cv');
        
        $rootNode
            ->children()
                ->scalarNode('copyright')
                    ->isRequired()
                ->end()
                ->scalarNode('default_cv')
                    ->isRequired()
                ->end()
                ->arrayNode('cvs')
                    ->prototype('array')
                        ->children()
                            ->enumNode('language')
                                ->isRequired()
                                ->values($this->validLanguages)
                            ->end()
                            ->arrayNode('options')
                                ->prototype('array')
                                    ->children()
                                        ->booleanNode('obfuscate_email')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('contact')
                                ->isRequired()
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->arrayNode('phones')->prototype('scalar')->end()->end()
                                    ->arrayNode('emails')->prototype('scalar')->end()->end()
                                ->end()
                            ->end()
                            ->scalarNode('summary')
                                ->isRequired()
                                ->defaultNull()
                            ->end()
                            ->arrayNode('education')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('title')->end()
                                        ->scalarNode('since')->end()
                                        ->scalarNode('until')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('occupation')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('position')->end()
                                        ->scalarNode('since')->end()
                                        ->scalarNode('until')->end()
                                        ->scalarNode('description')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('languages')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->enumNode('level')
                                            ->values($this->validLanguageLevels)
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();    

        return $treeBuilder;
    }
}
