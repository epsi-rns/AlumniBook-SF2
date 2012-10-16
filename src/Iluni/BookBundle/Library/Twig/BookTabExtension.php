<?php
namespace Iluni\BookBundle\Library\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Provides tabbed menu for each master-detail relationship available.
 * Tab menu displayed abvoe any operation in each CRUD view.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class BookTabExtension extends \Twig_Extension
{
    private $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function getFunctions()
    {
        return array(
            'tab_use'    => new \Twig_Function_Method($this, 'tabUse'),
            'tab_alumni'    => new \Twig_Function_Method($this, 'tabAlumni'),
            'tab_org'       => new \Twig_Function_Method($this, 'tabOrg'),
            'tab_map'       => new \Twig_Function_Method($this, 'tabMap'),
            'tab_extract'   => new \Twig_Function_Method($this, 'tabExtract')
        );
    }

    public function tabUse($kind)
    {
        switch($kind)
        {
            case 'alumni':
                $tab = $this->tabAlumni();
                break;
            case 'org':
                $tab = $this->tabOrg();
                break;
            case 'map':
                $tab = $this->tabMap();
                break;
            default:
                $message ='Tab not available! Use "alumni", "org" or "map"';
                throw new \Exception($message);
        }

        return $tab;
    }

    public function tabAlumni()
    {
        // no tuples (routing param, context var, translation, route)
        return array(
            'alumni'            => array('id', 'aid', 'Alumni', 'alumni_show'),
            'acommunities'      => array('aid', 'aid', 'Communities', 'acommunities_list'),
            'amap'              => array('aid', 'aid', 'Map', 'amap_list'),
            'residence'         => array('aid', 'aid', 'Home/ Residence', 'residence_list'),
            'acontacts'         => array('aid', 'aid', 'Personal Contacts', 'acontacts_list'),
            'adegrees'          => array('aid', 'aid', 'Academic Degrees', 'adegrees_list'),
            'aexperiences'      => array('aid', 'aid', 'Experiences', 'aexperiences_list'),
            'acompetencies'     => array('aid', 'aid', 'Competencies', 'acompetencies_list'),
            'acertifications'   => array('aid', 'aid', 'Certifications', 'acertifications_list')
        );
    }

    public function tabOrg()
    {
        // no tuples (routing param, context var, translation, route)
        return array(
            'org'       => array('id', 'oid', 'Organization', 'org_show'),
            'omap'      => array('oid', 'oid', 'Map', 'omap_list'),
            'office'    => array('oid', 'oid', 'Offices', 'office_list'),
            'ocontacts' => array('oid', 'oid', 'Contacts', 'ocontacts_list'),
            'ofields'   => array('oid', 'oid', 'Business Fields', 'ofields_list'),
        );
    }

    public function tabMap()
    {
        // no tuples (routing param, context var, translation, route)
        return array(
            'alumni'    => array('id', 'aid', 'Alumni', 'alumni_show'),
            'org'       => array('id', 'oid', 'Organization', 'org_show'),
            'amap'      => array('aid', 'aid', 'Occupation', 'amap_list'),
            'omap'      => array('oid', 'oid', 'Job Position', 'omap_list'),
            'workplace' => array('mid', 'mid', 'Workplaces', 'workplace_list'),
            'mcontacts' => array('mid', 'mid', 'Contacts', 'mcontacts_list'),
        );
    }

    public function tabExtract($tab, $hash)
    {
        // no tuples (routing param, context var, translation, route)
        $tab = array(
            'hash_id'  => $tab[0],
            'var_name' => $tab[1],
            'caption'  => $tab[2],
            'route'    => $tab[3]
        );

        $tab['id'] = $hash[$tab['var_name']];
        $parameters = array($tab['hash_id'] => $tab['id']);
        $tab['url'] = $this->generator->generate($tab['route'], $parameters, false);

        return $tab;
    }

    // for a service we need a name
    public function getName()
    {
        return 'tab_twig_tab_extension';
    }
}

