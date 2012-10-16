<?php

namespace Iluni\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class UserController extends Controller
{
    public function loginAction()
    {
        $attributes = $this->get('request')->attributes;
        $session    = $this->get('request')->getSession();

        if ($attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $options = array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );

        return $this->render('IluniBookBundle:Modules/User:login.html.twig', $options);
    }

    public function checkAction()
    {
        // The security layer will intercept this request
    }

    public function logoutAction()
    {
        // The security layer will intercept this request
    }
}

