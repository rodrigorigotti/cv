<?php

namespace RodrigoRigotti\Bundle\CVBundle\Controller;

use RodrigoRigotti\Bundle\CVBundle\Exception\CVNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Configuration\Route("/")
 */
class CVController extends Controller
{
    /**
     * @Configuration\Route("/{slug}", requirements={"slug" = "\w+"})
     * @Configuration\Template
     */
    public function viewAction($slug)
    {
        $cvs = $this->container->getParameter('cvs');
        if (!isset($cvs[$slug])) {
            throw new CVNotFoundException();
        }
        return array(
            'options'    => $cvs[$slug]['options'],
            'language'   => $cvs[$slug]['language'],
            'contact'    => $cvs[$slug]['contact'],
            'summary'    => $cvs[$slug]['summary'],
            'education'  => $cvs[$slug]['education'],
            'occupation' => $cvs[$slug]['occupation'],
            'languages'  => $cvs[$slug]['languages']);
    }
}
