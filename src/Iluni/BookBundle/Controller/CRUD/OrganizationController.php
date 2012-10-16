<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Organization;
use Iluni\BookBundle\Form\Entity\OrganizationType;

/**
 * Organization CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationController extends CommonCRUDController
{
    /**
     * Finds and displays a Organization entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Organization')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Organization:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Utility for testing purpose used by crawler
     *
     */
    public function firstAction($_format)
    {
        $id = $this->getRepository('Organization')->getFirstId();

        $bags = array('id'=>$id);

        if ($_format=='json') {
            $response = new Response(json_encode($bags));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $action = 'IluniBookBundle:CRUD\Organization:show';
            return $this->forward($action, $bags);
        }
    }

    /**
     * Displays a form to create a new Organization entity.
     *
     */
    public function newAction()
    {
        $entity = new Organization();
        $form   = $this->createForm(new OrganizationType(), $entity);

        return $this->renderTwig('Master/Organization:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Organization entity.
     *
     */
    public function createAction()
    {
        $entity  = new Organization();

        $request = $this->getRequest();
        $form    = $this->createForm(new OrganizationType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'org_edit', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()
            ->add('error', 'Not saved! Please verify entry.');

        return $this->renderTwig('Master/Organization:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Organization entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Organization')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new OrganizationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Organization:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Organization entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Organization')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new OrganizationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'org_edit', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()
            ->add('error', 'Not saved! Please verify entry.');

        return $this->renderTwig('Master/Organization:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Organization entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Organization')->find($id);
            $this->forward404UnlessExist($entity);

            $this->doctrineRemove($entity);
        }

        return $this->redirect($this->generateUrl('org'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Organization entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

