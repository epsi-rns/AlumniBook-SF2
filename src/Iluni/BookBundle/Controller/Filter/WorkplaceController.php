<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\MAddressFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Workplace filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class WorkplaceController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('maddress', $request)
            ->set(array('orderBy' => 6))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'workplace_partial_filter',
            'tableRoute'  => 'workplace_partial_table'
        );

        return $this->renderTwig('Detail/MapAddress:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Detail\MapAddress')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'workplace';

        return $this->renderTwig('Detail/MapAddress:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new MAddressFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('maddress', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'workplace',
                'use_fields' => array(),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

