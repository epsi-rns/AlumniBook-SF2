<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\AAddressFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Residence filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ResidenceController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('aaddress', $request)
            ->set(array('orderBy' => 6))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Residence:filter',
            'tableAction'  => 'IluniBookBundle:Filter/Residence:table'
        );

        return $this->renderTwig('Detail/AlumniAddress:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniAddress')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'aaddress';

        return $this->renderTwig('Detail/AlumniAddress:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new AAddressFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('aaddress', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'residence',
                'use_fields' => array(),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

