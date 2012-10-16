<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\AMapFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Organization filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AMapController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('amap', $request)
            ->set(array('orderBy' => 4))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/AMap:filter',
            'tableAction'  => 'IluniBookBundle:Filter/AMap:table'
        );

        return $this->renderTwig('Detail/AlumniMap:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findAlumniQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'amap';

        return $this->renderTwig('Detail/AlumniMap:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new AMapFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('amap', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'amap',
                'use_fields' => array('jobType'),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('amap', 'index', $params);
    }

    public function categoriesAction()
    {
        $entities = $this->getRepository('Category\JobType')->findCategories();

        return $this->renderTwig('Detail/AlumniMap:categories',
            array('cats' => $entities) );
    }

    public function categoryAction($cid)
    {
        return $this->forwardFilterPost(
            array('jobType' => $cid)
        );
    }
}

