<?php

namespace Iluni\BookBundle\Controller\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\Filter\OContactsFilter;

/**
 * OContacts filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OContactsController extends CommonFilterController
{
    public function indexAction(Request $request)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('ocontacts', $request)
            ->set(array('orderBy' => 6))
            ->compileOptions();

        $render_options = array(
            'params' => $params,
            'page'   => $request->query->getDigits('page', 1),
            'filterAction' => 'IluniBookBundle:Filter/OContacts:filter',
            'tableAction'  => 'IluniBookBundle:Filter/OContacts:table'
        );

        return $this->renderTwig('Detail/OrgContacts:index', $render_options);
    }

    public function tableAction($params, $page)
    {
        $query = $this
            ->getRepository('Detail\OrgContacts')
            ->findQueryFilter($params);

        $render_options = $this->processFilter($params, $query, $page);
        $render_options['path'] = 'ocontacts';

        return $this->renderTwig('Detail/OrgContacts:partial.table', $render_options);
    }

    public function filterAction($params)
    {
        $filterForm = $this->createForm(new OContactsFilter());
        $filterForm->bind($params);

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'options' => array(
                'path' => 'ocontacts',
                'use_fields' => array('contactType')
            )
        );

        return $this->renderTwig('List:filter/base', $render_options);
    }
}

