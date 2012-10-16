<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\OFieldsFilter;

/**
 * OFields filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OFieldsController extends CommonFilterController
{
    /**
     * Lists all OFields entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('ofields', $request)
            ->set(array('orderBy' => 23))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/OFields:filter',
            'tableAction'  => 'IluniBookBundle:Filter/OFields:table'
        );

        return $this->renderTwig('Detail/OrgFields:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\OrgFields')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'ofields';

        return $this->renderTwig('Detail/OrgFields:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new OFieldsFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'ofields',
                'use_fields' => array('bizField')
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('ofields', 'index', $params);
    }

    public function categoriesAction()
    {
        $entities = $this->getRepository('Category\BizField')->findCategories();

        return $this->renderTwig('Detail/OrgFields:categories',
            array('cats' => $entities) );
    }

    public function categoryAction($cid)
    {
        return $this->forwardFilterPost(
            array('bizField' => $cid)
        );
    }
}

