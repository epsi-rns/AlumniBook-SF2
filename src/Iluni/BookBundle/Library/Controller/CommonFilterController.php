<?php

namespace Iluni\BookBundle\Library\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Helper\GroupingHelper;

/**
 * Common controller.
 *
 */
class CommonFilterController extends CommonController
{
    // actual process
    protected function doForwardFilterPost($module_name, $action_name, $params)
    {
        $action_method = $action_name.'Action';

        $form_namespace = $this->getNamespace('filter', $module_name);
        $params_forward = array( $form_namespace => $params );

        $request = $this->getRequest();
        $route = '/'.$module_name.'?'.$request->getQueryString();

        $request = Request::create($route, 'POST', $params_forward);
        return $this->$action_method($request);
    }

    // sub processing
    protected function getPager($query, $page = 1)
    {
        $pager = $this->get('ideato.pager')
            ->setPage($page)
            ->setQuery($query)
            ->init();

        return $pager;
    }

    // get entities, pagination, and table groups
    protected function processFilter($params, $query, $page)
    {
        $pager = $this->getPager($query, $page);
        $entities = $pager->getResults();

        $GH = new GroupingHelper($entities);
        $groups = $GH->group($params['orderBy']);

        return array(
            'entities' => $entities,
            'groups' => $groups,
            'pager' => $pager
        );
    }
}

