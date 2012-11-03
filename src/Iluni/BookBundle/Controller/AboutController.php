<?php

namespace Iluni\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Citra\CommonBundle\Library\Controller\InitializableControllerInterface;
use Iluni\BookBundle\Library\Controller\CommonController;
use Iluni\BookBundle\Entity\Alumni;
use Iluni\BookBundle\Entity\Organization;

/**
 * About controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AboutController extends CommonController implements
    InitializableControllerInterface
{
    private $allowDebugAjax = false;

    public function initialize(Request $request)
    {
        $route  = $request->attributes->get('_route');
        $isAjax = $request->isXmlHttpRequest();

        $ajax_routes = array(
            'detail_alumni',
            'detail_org',
            'detail_alumni_org',
            'detail_org_alumni'
        );

        if (!$isAjax
            and !$this->allowDebugAjax
            and in_array($route, $ajax_routes)) {
            // further PSR
            $message = 'You are not assigned. Nice Try!';
            throw new NotFoundHttpException($message);
        }
    }

    public function alumniAction($aid)
    {
        $entity = $this
            ->getRepository('Alumni')
            ->find($aid);
        $maps = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findBy(array('alumni' => $aid));

        return $this->renderTwig('About/Alumni:main', array(
            'one' => $entity,
            'maps' => $maps
        ));
    }

    public function alumniSlugAction($slug)
    {
        $entity = $this
            ->getRepository('Alumni')
            ->findOneBySlug($slug);
        $aid = $entity->getId();
        $maps = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findBy(array('alumni' => $aid));

        return $this->renderTwig('About/Alumni:main', array(
            'one' => $entity,
            'maps' => $maps
        ));
    }

    public function orgAction($oid)
    {
        $entity = $this
            ->getRepository('Organization')
            ->find($oid);
        $maps = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findBy(array('organization' => $oid));

        return $this->renderTwig('About/Org:main', array(
            'one' => $entity,
            'maps' => $maps
        ));
    }

    public function orgSlugAction($slug)
    {
        $entity = $this
            ->getRepository('Organization')
            ->findOneBySlug($slug);
        $oid = $entity->getId();
        $maps = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findBy(array('organization' => $oid));

        return $this->renderTwig('About/Org:main', array(
            'one' => $entity,
            'maps' => $maps
        ));
    }

    public function adetAction($aid)
    {
        $alumni = $this
            ->getRepository('Alumni')
            ->find($aid);
        $acommunities    = $this
            ->getRepository('Detail\AlumniCommunities')
            ->findBy(array('alumni' => $aid));
        $acompetencies   = $this
            ->getRepository('Detail\AlumniCompetencies')
            ->findList($aid);
        $acertifications = $this
            ->getRepository('Detail\AlumniCertifications')
            ->findBy(array('alumni' => $aid));
        $aexperiences    = $this
            ->getRepository('Detail\AlumniExperiences')
            ->findBy(array('alumni' => $aid));
        $address  = $this
            ->getRepository('Detail\AlumniAddress')
            ->findBy(array('alumni' => $aid));
        $contacts = $this
            ->getRepository('Detail\AlumniContacts')
            ->findList($aid);

        return $this->renderTwig('About/Alumni:detail', array(
            'one' => $alumni,
            'birthInfo' => $this->getBirthInfo($alumni),
            'communities'       => $acommunities,
            'competencies'      => $acompetencies,
            'certifications'    => $acertifications,
            'experiences'       => $aexperiences,
            'address'   => $address,
            'contacts'  => $contacts
        ));
    }

    public function odetAction($oid)
    {
        $one = $this
            ->getRepository('Organization')
            ->find($oid);
        $parent   = $this
            ->getRepository('Organization')
            ->findParent($oid);
        $branches = $this
            ->getRepository('Organization')
            ->findBranches($oid);
        $ofields  = $this
            ->getRepository('Detail\OrgFields')
            ->findList($oid);
        $address  = $this
            ->getRepository('Detail\OrgAddress')
            ->findBy(array('organization' => $oid));
        $contacts = $this
            ->getRepository('Detail\OrgContacts')
            ->findList($oid);

        return $this->renderTwig('About/Org:detail', array(
            'one' => $one,
            'parent' => $parent,
            'branches' => $branches,
            'bizFields' => $ofields,
            'address'   => $address,
            'contacts'  => $contacts
        ));
    }

    public function adetoAction($mid)
    {
        $map = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findOneById($mid);
        $oid = $map
            ->getOrganization()
            ->getId();
        $oaddress  = $this
            ->getRepository('Detail\OrgAddress')
            ->findBy(array('organization' => $oid));
        $ocontacts = $this
            ->getRepository('Detail\OrgContacts')
            ->findList($oid);
        $maddress  = $this
            ->getRepository('Detail\MapAddress')
            ->findBy(array('alumni_org_map' => $mid));
        $mcontacts = $this
            ->getRepository('Detail\MapContacts')
            ->findList($mid);

        return $this->renderTwig('About/Alumni:map', array(
            'map' => $map,
            'JPInfo' => $this->getJobPositionInfo($map),
            'oaddress'  => $oaddress,
            'ocontacts' => $ocontacts,
            'maddress'  => $maddress,
            'mcontacts' => $mcontacts
        ));
    }

    public function odetaAction($mid)
    {
        $map = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findOneById($mid);
        $aid = $map
            ->getAlumni()
            ->getId();
        $aaddress  = $this
            ->getRepository('Detail\AlumniAddress')
            ->findBy(array('alumni' => $aid));
        $acontacts = $this
            ->getRepository('Detail\AlumniContacts')
            ->findList($aid);
        $maddress  = $this
            ->getRepository('Detail\MapAddress')
            ->findBy(array('alumni_org_map' => $mid));
        $mcontacts = $this
            ->getRepository('Detail\MapContacts')
            ->findList($mid);

        return $this->renderTwig('About/Org:map', array(
            'map' => $map,
            'JPInfo' => $this->getJobPositionInfo($map),
            'aaddress'  => $aaddress,
            'acontacts' => $acontacts,
            'maddress'  => $maddress,
            'mcontacts' => $mcontacts
        ));
    }

    private function getBirthInfo ($one)
    {
        $birthPlace = $one->getBirthPlace();
        $birthDate  = $one->getBirthDate();

        $items = array();
        if (!empty($birthPlace)) {
            $items[] = $birthPlace;
        }
        if (!empty($birthDate)) {
            $items[] = $birthDate->format('l, jS \of F Y');
        }

        return $items;
    }

    private function getJobPositionInfo ($map)
    {
        $items = array();
        if ($map->getFungsional()) {
            $items[] = $map->getFungsional();
        }
        if ($map->getStruktural()) {
            $items[] = $map->getStruktural();
        }
        if ($map->getDescription()) {
            $items[] = $map->getDescription();
        }

        return $items;
    }
}

