<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\BirthdayFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Birthday filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class BirthdayController extends CommonFilterController
{
    /**
     * Lists all birthday of alumni entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('birthday', $request)
            ->set(array('orderBy' => 1))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Birthday:filter',
            'tableAction'  => 'IluniBookBundle:Filter/Birthday:table'
        );

        return $this->renderTwig('Master/Birthday:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Alumni')
            ->findQueryBirthdayFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'alumni_birthday';

        return $this->renderTwig('Master/Birthday:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new BirthdayFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'alumni_birthday',
                'use_fields' => array()
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

