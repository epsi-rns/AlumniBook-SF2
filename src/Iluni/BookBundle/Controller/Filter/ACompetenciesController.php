<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\ACompetenciesFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * ACompetencies filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACompetenciesController extends CommonFilterController
{
    /**
     * Lists all ACompetencies entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('acompetencies', $request)
            ->set(array('orderBy' => 105))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/ACompetencies:filter',
            'tableAction'  => 'IluniBookBundle:Filter/ACompetencies:table'
        );

        return $this->renderTwig('Detail/AlumniCompetencies:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniCompetencies')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'acompetencies';

        return $this->renderTwig('Detail/AlumniCompetencies:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new ACompetenciesFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('acompetencies', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'acompetencies',
                'use_fields' => array('competency'),
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }

    private function forwardFilterPost($params)
    {
        return $this->doForwardFilterPost('acompetencies', 'index', $params);
    }

    public function categoriesAction()
    {
        $entities = $this->getRepository('Category\Competency')->findCategories();

        return $this->renderTwig('Detail/AlumniCompetencies:categories',
            array('cats' => $entities) );
    }

    public function categoryAction($cid)
    {
        return $this->forwardFilterPost(
            array('competency' => $cid)
        );
    }
}

