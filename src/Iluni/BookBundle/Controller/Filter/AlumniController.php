<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\AlumniFilter;
use Iluni\BookBundle\Form\Filter\BirthFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * Alumni filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AlumniController extends CommonFilterController
{
    /**
     * Lists all Alumni entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('alumni', $request)
            ->set(array('orderBy' => 1))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Alumni:filter',
            'tableAction'  => 'IluniBookBundle:Filter/Alumni:table'
        );

        return $this->renderTwig('Master/Alumni:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Alumni')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'alumni';

        return $this->renderTwig('Master/Alumni:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new AlumniFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('alumni', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'alumni',
                'use_fields' => array('name', 'update_st', 'update_nd'),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    public function birthAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('birth', $request)
            ->set(array('orderBy' => 1))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/Alumni:birthfilter',
            'tableAction'  => 'IluniBookBundle:Filter/Alumni:birthtable'
        );

        return $this->renderTwig('Master/Alumni:birth', $render_options);
    }

    public function birthtableAction($params, $page)
    {
        $query = $this
            ->getRepository('Alumni')
            ->findQueryBirthdayFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'alumni_birth';

        return $this->renderTwig('Master/Alumni:partial.birthtable', $render_options);
    }

    public function birthfilterAction($params)
    {
        $filterForm = $this->createForm(new BirthFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'alumni_birth',
                'use_fields' => array()
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

