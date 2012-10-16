<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\ACertificationsFilter;

use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;

/**
 * ACertifications filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACertificationsController extends CommonFilterController
{
    /**
     * Lists all ACertifications entities.
     *
     */
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('acertifications', $request)
            ->set(array('orderBy' => 105))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/ACertifications:filter',
            'tableAction'  => 'IluniBookBundle:Filter/ACertifications:table'
        );

        return $this->renderTwig('Detail/AlumniCertifications:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\AlumniCertifications')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'acertifications';

        return $this->renderTwig('Detail/AlumniCertifications:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new ACertificationsFilter());
        $filterForm->bind($params);

        $ld3 = new DepartmentFilterLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('acertifications', $params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'acertifications',
                'ld3' => $JSOptions
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

