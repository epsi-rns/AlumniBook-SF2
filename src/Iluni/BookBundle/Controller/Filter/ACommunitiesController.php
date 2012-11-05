<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\ACommunitiesFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * ACommunitiesFilter filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACommunitiesController extends CommonFilterController
{
    /**
     * Lists all ACommunities entities.
     *
     */
    public function filtrateAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('acommunities', $request)
            ->set(array('orderBy' => 85))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'acommunities_partial_filter',
            'tableRoute'  => 'acommunities_partial_table'
        );

        $params_summary = $this->getSummaryParams($params);
        if ($params_summary['show']) {
            $render_options['summary'] = $params_summary;
        }

        return $this->renderTwig('Detail/AlumniCommunities:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Detail\AlumniCommunities')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'acommunities';

        return $this->renderTwig('Detail/AlumniCommunities:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new ACommunitiesFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('acommunities', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'acommunities',
                'use_fields' => array(),
                'ld3' => $JSOptions
            ),
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('acommunities', 'filtrate', $params);
    }

    public function summaryAction($pid, $fid, $did)
    {
        $pairs = $this->getRepository('Detail\AlumniCommunities')->findSummary($pid, $fid, $did);
        return $this->renderTwig('Detail/AlumniCommunities:summary', array('pairs' => $pairs));
    }

    public function programAction($pid)
    {
        $entity = $this->getRepository('Category\Program')->find($pid);
        $this->forward404UnlessExist($entity);

        return $this->forwardFilterPost(
            array('community' => array('program' => $pid) )
        );
    }

    public function facultyAction($fid)
    {
        $entity = $this->getRepository('Category\Faculty')->find($fid);
        $this->forward404UnlessExist($entity);

        return $this->forwardFilterPost(
            array('community' => array('faculty' => $fid) )
        );
    }

    public function departmentAction($did)
    {
        $entity = $this->getRepository('Category\Department')->find($did);
        $this->forward404UnlessExist($entity);

        $community = array(
            'faculty' => $entity->getFaculty()->getId(),
            'department' => $did
        );

        return $this->forwardFilterPost(
            array('community' => $community )
        );
    }

    public function communityAction($cid)
    {
        $entity = $this->getRepository('Community')->find($cid);
        $this->forward404UnlessExist($entity);

        $community = array(
            'program' => $entity->getProgram()->getId(),
            'faculty' => $entity->getFaculty()->getId(),
            'department' => $entity->getDepartment()->getId()
        );

        return $this->forwardFilterPost(
            array('community' => $community )
        );
    }

    public function comyearAction($cid, $year)
    {
        $entity = $this->getRepository('Community')->find($cid);
        $this->forward404UnlessExist($entity);

        $community = array(
            'program' => $entity->getProgram()->getId(),
            'faculty' => $entity->getFaculty()->getId(),
            'department' => $entity->getDepartment()->getId(),
            'classYear' => $year
        );

        return $this->forwardFilterPost(
            array('community' => $community )
        );
    }

    public function yearAction($year)
    {
        $params_request = array('community' =>  array(
            'decade' => '', 'classYear' => $year
        ));

        $holder = $this->get('iluni_book.filter_options_holder');
        $params_replace = $holder
            ->init('acommunities', $this->get('request'))
            ->ifKeepSessionMergeParams($params_request);

        return $this->forwardFilterPost($params_replace);
    }

    public function decadeAction($decade)
    {
        $params_request = array('community' =>  array(
            'decade' => $decade, 'classYear' => ''
        ));

        $holder = $this->get('iluni_book.filter_options_holder');
        $params_replace = $holder
            ->init('acommunities', $this->get('request'))
            ->ifKeepSessionMergeParams($params_request);

        return $this->forwardFilterPost($params_replace);
    }

    private function getSummaryParams($params)
    {
        $show = false;

        if (isset($params['community'])) {
            extract($params['community']);

            if (empty($classYear) and empty($decade)) {
                $show = true;
            }
        } else {
            $show = true;
        }

        // generate by extract variables
        return array(
            'show' => $show,
            'program' => empty($program)? 0: $program,
            'faculty' => empty($faculty)? 0: $faculty,
            'department' => empty($department)? 0: $department
        );
    }


    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Filter entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

