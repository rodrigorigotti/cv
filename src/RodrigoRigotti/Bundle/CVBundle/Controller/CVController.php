<?php

namespace RodrigoRigotti\Bundle\CVBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Configuration\Route("/")
 */
class CVController extends Controller
{
    /**
     * @Configuration\Route("/")
     */
    public function indexAction()
    {
        $defaultCv = $this->container->getParameter('default_cv');
        $cvs = $this->container->getParameter('cvs');
        if (!isset($cvs[$defaultCv])) {
            return $this->generateCVNotFoundException($defaultCv);
        }
        return $this->forward(
            'RodrigoRigottiCVBundle:CV:view',
            array('slug' => $defaultCv));
    }
    
    /**
     * @Configuration\Route("/{slug}", requirements={"slug" = "\w+"})
     */
    public function viewAction($slug)
    {
        $cvs = $this->container->getParameter('cvs');
        if (!isset($cvs[$slug])) {
            return $this->generateCVNotFoundException($slug);
        }
        $cv = $cvs[$slug];
        return $this->render('RodrigoRigottiCVBundle:CV:view.html.twig', array(
            'copyright'  => $this->container->getParameter('copyright'),
            'options'    => $cv['options'],
            'language'   => $cv['language'],
            'contact'    => $cv['contact'],
            'summary'    => $cv['summary'],
            'education'  => $cv['education'],
            'occupation' => $cv['occupation'],
            'languages'  => $cv['languages']));
    }
    
    private function generateCVNotFoundException($slug)
    {
        return $this->render('RodrigoRigottiCVBundle:exceptions:cvNotFound.html.twig', array(
            'slug' => $slug
        ));
    }
}
