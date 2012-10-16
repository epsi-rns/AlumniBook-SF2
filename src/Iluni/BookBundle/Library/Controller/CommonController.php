<?php

namespace Iluni\BookBundle\Library\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Helper\GroupingHelper;
use Iluni\BookBundle\Library\Helper\IluniBookHelper;

/**
 * Common controller.
 *
 */
class CommonController extends Controller
{
    // magic namespace, DRY and uniform
    protected function getNamespace($type, $name)
    {
        return IluniBookHelper::getNamespace($type, $name);
    }

    // shortcut
    protected function renderTwig($twig_filename, $render_options)
    {
        $twig_namespace = $this->getNamespace('twig', $twig_filename);
        return $this->render($twig_namespace, $render_options);
    }

    // shortcut
    protected function getRepository($repo_classname)
    {
        $repo_namespace = $this->getNamespace('repository', $repo_classname);
        $em = $this->getDoctrine()->getEntityManager();
        return $em->getRepository($repo_namespace);
    }
}

