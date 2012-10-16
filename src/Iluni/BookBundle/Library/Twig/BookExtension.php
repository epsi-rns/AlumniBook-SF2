<?php
namespace Iluni\BookBundle\Library\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * BookExtension is miscellanous twig Helper for IluniBook views.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class BookExtension extends \Twig_Extension
{
    protected $now = null;

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->translator = $container->get('translator');
    }

    public function getGlobals()
    {
        return array(
            'book_app' => $this->getModuleActionName()
        );
    }

    // the magic function that makes this easy
    public function getFilters()
    {
        return array(
            'var_dump'  => new \Twig_Filter_Function('var_dump'),
            'sha1'      => new \Twig_Filter_Function('sha1'),
            'th'        => new \Twig_Filter_Method(
                $this,
                'theader',
                array('pre_escape' => 'html', 'is_safe' => array('html'))
                ),
            'feedTime'  => new \Twig_Filter_Method($this, 'feedTime'),
            'textShort' => new \Twig_Filter_Method($this, 'textShort'),
            'pastDateImage' => new \Twig_Filter_Method(
                $this,
                'pastDateImage',
                array('pre_escape' => 'html', 'is_safe' => array('html'))
            ),
            'salute'    => new \Twig_Filter_Method($this, 'salute'),
        );
    }

    public function theader($text, $domain = 'forms')
    {
        $t = $this->translator->trans($text, array(), $domain);
        return '<th>'.$t.'</th>';
    }

    public function feedTime($ormdate)
    {
        $datetime = new \DateTime(trim($ormdate));
        $timestamp = $datetime->format('U');

        $timeformat = '%Y-%m-%dT%H:%M:%SZ';
        return gmstrftime($timeformat, $timestamp);
    }

    public function textShort($string, $length = 35, $end = '...')
    {
        if (mb_strlen($string) > $length) {
            $string = mb_substr($string, 0, $length).$end;
        }

        return $string;
    }

    public function pastDateImage($datetime)
    {
        $this->now = new \DateTime();
        $interval = $datetime->diff($this->now);
        $pastdate = (int) $interval->format('%a');

        $img = null;
        if (($pastdate-15) < 0) {
            $img='new1.png';
        } elseif (($pastdate-40) < 0) {
            $img='new2.png';
        }
        elseif (($pastdate-100) < 0) {
            $img='new3.png';
        }

        $assets = $this->container->get('templating.helper.assets');
        $url = '/bundles/ilunibook/images/silk/'.$img;
        $url = $assets->getUrl($url);

        return !empty($img)? '&nbsp;<img src="'.$url.'" border="0"/>' : '';
    }

    public function salute($entity)
    {
        $salute = '';
        $gender =   $entity->getGender();

        // possible bug with zero date validation ignored
        $birthdate = $entity->getBirthdate();

        switch ($gender) {
            case 'M':
                $salute = 'Mr.';
                break;
            case 'F':
                $salute = 'Ms.';
                break;
            default:
                $salute = 'Alumna/us';
        }

        if (!empty($birthdate)) {
            $today = new \DateTime();
            $interval = $birthdate->diff($today);
            $yeardiff = (int) $interval->format('%y');

            if (($yeardiff>15) && ($yeardiff<40)) {
                switch ($gender) {
                    case 'M':
                        $salute = 'Brother';
                        break;
                    case 'F':
                        $salute = 'Sister';
                        break;
                }
            } // diffyear
        }

        return $salute;
    }

    // http://www.kamiladryjanek.com/2011/11/\
    // symfony2-get-controller-action-name-in-twig-template/
    private function getModuleActionName()
    {
        $request = $this->container->get('request');
        $controller = $request->get('_controller');

        $module = '';
        $action = '';

        $pattern_module = "#Controller\\\([a-zA-Z]*\\\*[a-zA-Z]*)Controller#";
        $pattern_action = "#::([a-zA-Z]*)Action#";

        $matches_module = array();
        $matches_action = array();

        preg_match($pattern_module, $controller, $matches_module);
        preg_match($pattern_action, $controller, $matches_action);


        if (!empty($matches_module)) {
            $module = strtolower($matches_module[1]);
        }

        if (!empty($matches_action)) {
            $action = strtolower($matches_action[1]);
        }

        $disallowed_action = array('list', 'show', 'new', 'edit');
        $disallowed_module = array('crud', 'filter');

        $allow_menu = (! in_array($action, $disallowed_action) );

        $allow_more_effects = true;
        foreach ($disallowed_module as $find) {
            if (false!==strpos($module, $find)) {
                $allow_more_effects = false;
            }
        }

        $book_app = array(
            'module' => $module,
            'action' => $action,
            'allow_menu' => $allow_menu,
            'allow_more_effects' => $allow_more_effects
        );

        return $book_app;
    }


    // for a service we need a name
    public function getName()
    {
        return 'ilunibook_twig_extension';
    }
}

