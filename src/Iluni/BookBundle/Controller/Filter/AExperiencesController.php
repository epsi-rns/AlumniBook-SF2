<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\AExperiencesFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * AExperiences filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AExperiencesController extends CommonFilterController
{
    /**
     * Lists all AExperiences entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('aexperiences', $request)
            ->set(array('orderBy' => 105))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterRoute' => 'aexperiences_partial_filter',
            'tableRoute'  => 'aexperiences_partial_table'
        );

        return $this->renderTwig('Detail/AlumniExperiences:index', $render_options);
    }

    public function tableAction(Request $request)
    {
        $params = $request->query->all();
        $page = (int) $params['page'];

        $query = $this
            ->getRepository('Detail\AlumniExperiences')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'aexperiences';

        return $this->renderTwig('Detail/AlumniExperiences:partial.table', $render_options);
    }

    public function filterAction(Request $request)
    {
        $params = $request->query->all();

        $filterForm = $this->createForm(new AExperiencesFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('aexperiences', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'aexperiences',
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

