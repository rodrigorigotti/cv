<?php

namespace RodrigoRigotti\Bundle\CVBundle\Twig;

class ExtrasExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('obfuscate_emails', array($this, 'obfuscateEmailsFilter'))
        );
    }
    
    public function obfuscateEmailsFilter(array $emails = array())
    {
        for ($i = 0, $count = sizeof($emails); $i < $count; $i++) {
            $emails[$i] = str_replace('@', ' [at] ', $emails[$i]);
        }
        return $emails;
    }
    
    public function getName()
    {
        return 'extras_extension';
    }
}
