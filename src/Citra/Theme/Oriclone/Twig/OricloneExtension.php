<?php
namespace Citra\Theme\Oriclone\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * OricloneExtension take care of themes variable set in configuration.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OricloneExtension extends \Twig_Extension
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return array(
            'oriclone' => $this->getOricloneConfig()
        );
    }

    public function getFunctions()
    {
        return array(
            'mergetitle'    => new \Twig_Function_Method($this, 'mergeTitle'),
        );
    }

    private function getOricloneConfig()
    {
        $container = $this->container;
        $config = $this->container->getParameter('oriclone.config');

        return $config;
    }

    public function mergeTitle($main, $sub)
    {
        $titles = [];

        if ($main) {
            $titles[] = $main;
        }

        if ($sub) {
            $titles[] = $sub;
        }

        return implode($titles, ' - ');
    }

    // for a service we need a name
    public function getName()
    {
        return 'oriclone_twig_extension';
    }
}

