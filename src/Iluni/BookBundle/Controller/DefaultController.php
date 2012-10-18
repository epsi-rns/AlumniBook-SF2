<?php

namespace Iluni\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iluni\BookBundle\Form\LocaleForm;

/**
 * Default controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $localeForm = $this->checkLocaleForm($request);
        $translator = $this->get('translator');

        $em = $this->getDoctrine()->getEntityManager();
        $last_update = $em
            ->getRepository('IluniBookBundle:Alumni')
            ->getLastUpdateForCover($translator);

        $options = array(
            'locale_form'   => $localeForm->createView(),
            'lastupdate' => $last_update
        );

        return $this->render('IluniBookBundle:Modules/Default:index.html.twig', $options);
    }

    public function languageAction($locale, $_format)
    {
        $this->get('session')->set('_locale', $locale);

        if ($_format=='json') {
            $bags = array('locale'=>$locale);
            $response = new Response(json_encode($bags));
            $response->headers->set('Content-type', 'application/json');
            return $response;
        } else {
            $response = $this->forward('IluniBookBundle:Modules/Default:index');
            return $response;
        }
    }

    public function aboutAction()
    {
        return $this->render('IluniBookBundle:Modules/Default:about.html.twig');
    }

    public function menuAction(Request $request)
    {
        return $this->render('IluniBookBundle:Modules/Default:menu.html.twig', array(
            'route' => $request->query->get('route', '')
        ));
    }

    public function screenshotAction()
    {
        return $this->render('IluniBookBundle:Modules/Default:screenshot.html.twig');
    }

    public function feedAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em
            ->getRepository('IluniBookBundle:Alumni')
            ->findForAtom();
        $last_update = $em
            ->getRepository('IluniBookBundle:Alumni')
            ->getLastUpdate();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        return $this->render(
            'IluniBookBundle:Modules/Default:feed.xml.twig',
            array('entities' => $entities, 'last_update' => $last_update),
            $response
        );
    }

    public function departmentsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em
            ->getRepository('IluniBookBundle:Category\Faculty')
            ->findCategories();

        return $this->render(
            'IluniBookBundle:Modules/Default:departments.html.twig',
            array('faculties' => $entities)
        );
    }

    private function checkLocaleForm(Request $request)
    {
        $localeForm = $this->createForm(new LocaleForm());

        if ('POST' == $request->getMethod()) {
            $name = $localeForm->getName();
            $params = (array) $request->request->get($name);
            $locale = $params['locale'];
            $this->get('session')->set('_locale', $locale);
        } else {
            $defaultLocale = $request->getLocale();
            $locale = $this->get('session')->get('_locale', $defaultLocale);
            $params = array('locale' => $locale);
        }

        $request->setLocale($locale);
        $localeForm->bind($params);


        return $localeForm;
    }
}

