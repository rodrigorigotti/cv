<?php

namespace RodrigoRigotti\Bundle\CVBundle\DependencyInjection;

use RodrigoRigotti\Bundle\CVBundle\Exception\InvalidLanguageException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    private $languageMappings = array(
        'php' => array('php3', 'php4', 'php5')
    );
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rodrigo_rigotti_cv');
        
        $rootNode
            ->children()
                ->arrayNode('cvs')
                    ->prototype('array')
                        ->children()
                            ->enumNode('language')
                                ->values($this->getValidLanguages())
                                ->beforeNormalization()
                                ->always(function($v) {
                                    if (isset($this->languageMappings[$v])) {
                                        return $v;
                                    }
                                    foreach ($this->languageMappings as $language => $mappings) {
                                        if (in_array($v, $mappings)) {
                                            return $language;
                                        }
                                    }
                                    throw new InvalidLanguageException("The selected language ('$v') is invalid or not yet supported.");
                                })
                                ->end()
                            ->end()
                            ->arrayNode('options')
                                ->prototype('array')
                                    ->children()
                                        ->booleanNode('obfuscate_email')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('contact')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->arrayNode('phones')->prototype('scalar')->end()->end()
                                    ->arrayNode('emails')->prototype('scalar')->end()->end()
                                ->end()
                            ->end()
                            ->scalarNode('summary')->end()
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
                                        ->scalarNode('level')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();    

        return $treeBuilder;
    }
    
    private function getValidLanguages()
    {
        $languages = array();
        foreach ($this->languageMappings as $mapped => $mappings) {
            $languages = array_merge($languages, array($mapped), $mappings);
        }
        return $languages;
    }
}
