<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\CommunityFilter;

/**
 * Community filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('community', $request)
            ->set(array('orderBy' => 94))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Community:filter',
            'tableAction'  => 'IluniBookBundle:Filter/Community:table'
        );

        return $this->renderTwig('Master/Community:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Community')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'community';

        return $this->renderTwig('Master/Community:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new CommunityFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'community',
                'use_fields' => array('program', 'faculty', 'department')
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

