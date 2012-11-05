<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\MContactsFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * MContacts filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class MContactsController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('mcontacts', $request)
            ->set(array('orderBy' => 6))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'mcontacts_partial_filter',
            'tableRoute'  => 'mcontacts_partial_table'
        );

        return $this->renderTwig('Detail/MapContacts:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Detail\MapContacts')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'mcontacts';

        return $this->renderTwig('Detail/MapContacts:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new MContactsFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('mcontacts', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'mcontacts',
                'use_fields' => array('contactType'),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

