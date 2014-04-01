<?php

namespace RodrigoRigotti\Bundle\CVBundle\Twig;

use RodrigoRigotti\Bundle\CVBundle\Exception\InvalidVariableTypeException;

class PhpExtension extends \Twig_Extension implements LanguageExtensionInterface
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('generate_class_constant', array($this, 'generateClassConstantFilter')),
            new \Twig_SimpleFilter('generate_class_name', array($this, 'generateClassNameFilter')),
            new \Twig_SimpleFilter('generate_text_block', array($this, 'generateTextBlockFilter'))
        );
    }
    
    public function generateClassNameFilter($string)
    {
        if (!is_string($string)) {
            throw new InvalidVariableTypeException();
        }
        return preg_replace('/\s+/', '', trim(ucwords(strtolower($string))));
    }
    
    public function generateClassConstantFilter($string, $className)
    {
        if (!is_string($string)) {
            throw new InvalidVariableTypeException();
        }
        return $className.'::'.preg_replace('/\s+/', '_', trim(strtoupper($string)));
    }
    
    public function generateTextBlockFilter($string, $delimiter, $tabSize, $concatCharacter, $width = 80, $break = PHP_EOL, $cut = false)
    {
        if (!is_string($string)) {
            throw new InvalidVariableTypeException();
        }
        $lines = explode(PHP_EOL, $string);
        $textBlock = array();
        for ($i = 0; $i < sizeof($lines); $i++) {
            $line = wordwrap($lines[$i], $width, $break, $cut);
            $lineParts = explode(PHP_EOL, $line);
            for ($j = 0; $j<sizeof($lineParts); $j++) {
                $textBlock[] = str_repeat(" ", $tabSize*4).$delimiter.$lineParts[$j].(($j === sizeof($lineParts)-1 && $i === sizeof($lines)-1) ? $delimiter : " ".$delimiter.$concatCharacter);
            }
        }
        return implode(PHP_EOL, $textBlock);
    }
    
    public function getName()
    {
        return 'php_extension';
    }
}
