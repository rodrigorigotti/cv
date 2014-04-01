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
        'php', 'js'
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
                ->scalarNode('default_cv')->end()
                ->arrayNode('cvs')
                    ->prototype('array')
                        ->children()
                            ->enumNode('language')
                                ->values($this->getValidLanguages())
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
    
    private function validateLanguage($language)
    {
        if (isset($this->languageMappings[$language])) {
            return $language;
        }
        foreach ($this->languageMappings as $mapped => $mappings) {
            if (in_array($language, $mappings)) {
                return $mapped;
            }
        }
        throw new InvalidLanguageException("The selected language ('$language') is invalid or not yet supported.");
    }
    
    private function getValidLanguages()
    {
        $languages = array();
//        foreach ($this->languageMappings as $mapped => $mappings) {
//            $languages = array_merge($languages, array($mapped), $mappings);
//        }
        $languages = $this->languageMappings;
        return $languages;
    }
}
