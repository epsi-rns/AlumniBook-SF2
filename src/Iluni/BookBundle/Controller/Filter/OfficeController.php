<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\OAddressFilter;

/**
 * Office filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OfficeController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('oaddress', $request)
            ->set(array('orderBy' => 6))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Office:filter',
            'tableAction'  => 'IluniBookBundle:Filter/Office:table'
        );

        return $this->renderTwig('Detail/OrgAddress:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\OrgAddress')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'office';

        return $this->renderTwig('Detail/OrgAddress:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new OAddressFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'office',
                'use_fields' => array()
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

