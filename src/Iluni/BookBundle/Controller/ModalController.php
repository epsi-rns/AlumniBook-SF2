<?php

namespace Iluni\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonFilterController;
use Iluni\BookBundle\Form\ModalFilter;

/**
 * Modal controller.
 *
 * This modal controller should only be used in iframe box.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ModalController extends CommonFilterController
{
    protected function genericAction(Request $request, $class, $route)
    {
        $holder = $this->get('iluni_book.filter_options_holder');
        $params = $holder
            ->init('modal', $request)
            ->compileOptions();

        $filterForm = $this->createForm(new ModalFilter());
        if ($request->getMethod() == 'POST') {
            $filterForm->bind($request);
        }

        $name = isset($params['name'])? $params['name']: null;

        $query = $this
            ->getRepository($class)
            ->findQueryNameLike($name);

        $page = $request->query->getDigits('page', 1);
        $pager = $this->getPager($query, $page);
        $entities = $pager->getResults();

        $render_options = array(
            'filter_form'   => $filterForm->createView(),
            'entities' => $entities,
            'pager'    => $pager,
            'path'     => $route
        );

        $template = 'IluniBookBundle:Shared/Modal:index.html.twig';

        $response = new Response();
        $response->headers->set('Content-type', 'text/xml');

        return $this->render($template, $render_options, $response);
    }

    public function alumniAction(Request $request)
    {
        return $this->genericAction($request, 'Alumni', 'modal_alumni');
    }

    public function orgAction(Request $request)
    {
        return $this->genericAction($request, 'Organization', 'modal_org');
    }

    public function communityAction(Request $request)
    {
        return $this->genericAction($request, 'Community', 'modal_community');
    }
}

