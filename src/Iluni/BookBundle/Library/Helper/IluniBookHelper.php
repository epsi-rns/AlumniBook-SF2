<?php

namespace Iluni\BookBundle\Library\Helper;

class IluniBookHelper
{
    // magic namespace, DRY and uniform, specific for this bundle
    public static function getNamespace($type, $name)
    {
        if (empty($name)) {
            throw new \Exception('Name must be set!');
        }

        // form name rely on convention, name your form manually
        switch(strtolower($type))
        {
            case 'session':
                $namespace = $name.'_filter';
                break;
            case 'type':
                $namespace = 'iluni_bookbundle_'.$name.'type';
                break;
            case 'filter':
                $namespace = 'iluni_bookbundle_'.$name.'filter';
                break;
            case 'twig':
                $namespace = 'IluniBookBundle:'.$name.'.html.twig';
                break;
            case 'repository':
                $namespace = 'IluniBookBundle:'.$name;
                break;
            default:
                throw new \Exception('Type mismatch in filter options holder!');
        }

        return $namespace;
    }
}

