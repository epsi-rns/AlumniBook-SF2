<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\ADegreesFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * ADegrees filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ADegreesController extends CommonFilterController
{
    /**
     * Lists all ADegrees entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('adegrees', $request)
            ->set(array('orderBy' => 105))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/ADegrees:filter',
            'tableAction'  => 'IluniBookBundle:Filter/ADegrees:table'
        );

        return $this->renderTwig('Detail/AlumniDegrees:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniDegrees')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'adegrees';

        return $this->renderTwig('Detail/AlumniDegrees:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new ADegreesFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('adegrees', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'adegrees',
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

