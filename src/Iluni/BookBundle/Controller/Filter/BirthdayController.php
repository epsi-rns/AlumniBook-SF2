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
            ->set(array('orderBy' => 75))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'alumni_birthday_partial_filter',
            'tableRoute'  => 'alumni_birthday_partial_table'
        );

        return $this->renderTwig('Master/Birthday:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Alumni')
            ->findQueryBirthdayFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'alumni_birthday';

        return $this->renderTwig('Master/Birthday:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new BirthdayFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'alumni_birthday',
                'use_fields' => array('monthBy')
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('birthday', 'index', $params);
    }

    public function monthAction($month)
    {
        return $this->forwardFilterPost(
            array('monthBy' => $month)
        );
    }
}

