<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\OMapFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Organization filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OMapController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('omap', $request)
            ->set(array('orderBy' => 4))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/OMap:filter',
            'tableAction'  => 'IluniBookBundle:Filter/OMap:table'
        );

        return $this->renderTwig('Detail/OrgMap:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findOrgQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'omap';

        return $this->renderTwig('Detail/OrgMap:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new OMapFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('omap', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'omap',
                'use_fields' => array('jobPosition'),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('omap', 'index', $params);
    }

    public function categoriesAction()
    {
        $entities = $this->getRepository('Category\JobPosition')->findCategories();

        return $this->renderTwig('Detail/OrgMap:categories',
            array('cats' => $entities) );
    }

    public function categoryAction($cid)
    {
        return $this->forwardFilterPost(
            array('jobPosition' => $cid)
        );
    }
}

