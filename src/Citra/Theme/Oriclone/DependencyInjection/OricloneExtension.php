<?php

namespace Citra\Theme\Oriclone\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * OrciloneExtension.
 *
 * This is the class that loads and manages your bundle configuration
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OricloneExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // transform
        $config['layout']['classes'] = $this
            ->getOricloneStyleClasses($config['layout']['classes']);
        $config['layout']['css'] = $this
            ->getOricloneStyleSheets($config['layout']['css']);
        $config['modal']['css'] = $this
            ->getOricloneStyleSheets($config['modal']['css']);
        $config['layout']['options'] = $this
            ->prepareOptions($config);

        $container->setParameter('oriclone.config', $config);
    }

    private function prepareOptions($config)
    {

        $options = $config['layout']['options'];

        // Main Layout
        $layout = 'lcr';
        extract($config['layout']['blocks']);

        if (!$left) {
            $layout = str_replace('l', '', $layout);
        }
        if (!$right) {
            $layout = str_replace('r', '', $layout);
        }
        $options['layout'] = $layout;

        $options['show_left']   = $left     && (strpos($layout, 'l')!==false);
        $options['show_right']  = $right    && (strpos($layout, 'r')!==false);

        $options['flip_leftright'] = ($layout=='rlc') || ($layout=='clr');
        $options['main_layout'] = 'pos_'.$layout;

        return $options;
    }

    private function getOricloneStyleClasses($class_s)
    {
        extract($class_s);
        $class=array();

        if (isset($width_style)) {
            $class[] = 'width_' .$width_style;
        }

        if (isset($background_main)) {
            $class[] = 'mbg_'   .$background_main;
        }

        if (isset($background_header)) {
            $class[] = 'hbg_'   .$background_header;
        }

        if (isset($variation_top)) {
            $class[] = $variation_top;
        }

        return implode(' ', $class);
    }

    public function getOricloneStyleSheets($css_s)
    {
        extract($css_s);
        $css = array();

        if (isset($text_scheme)) {
            $css[] = 'scheme/'.$text_scheme.'.css';
        }

        if (isset($strip_normal)) {
            $css[] = 'strip/'.$strip_normal.'.css';
        }

        if (isset($strip_hover)) {
            $css[] = 'hover/'.$strip_hover.'.css';
        }

        if (isset($marble)) {
            $css[] = 'marble/'.$marble.'.css';
        }

        return $css;
    }
}

