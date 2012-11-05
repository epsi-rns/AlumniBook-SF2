<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\OrganizationFilter;

/**
 * Organization filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationController extends CommonFilterController
{
    /**
     * Lists all Organization entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('organization', $request)
            ->set(array('orderBy' => 25))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'org_partial_filter',
            'tableRoute'  => 'org_partial_table'
        );

        return $this->renderTwig('Master/Organization:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Organization')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'org';

        return $this->renderTwig('Master/Organization:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new OrganizationFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'org',
                'use_fields' => array('name', 'update_st', 'update_nd'),
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

