<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Alumni;
use Iluni\BookBundle\Form\Entity\AlumniType;

/**
 * Alumni CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AlumniController extends CommonCRUDController
{
    /**
     * Finds and displays a Alumni entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Alumni')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Alumni:show', array(
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
        $id = $this->getRepository('Alumni')->getFirstId();

        $bags = array('id'=>$id);

        if ($_format=='json') {
            $response = new Response(json_encode($bags));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $action = 'IluniBookBundle:CRUD\Alumni:show';
            return $this->forward($action, $bags);
        }
    }

    /**
     * Displays a form to create a new Alumni entity.
     *
     */
    public function newAction()
    {
        $entity = new Alumni();
        $form   = $this->createForm(new AlumniType(), $entity);

        return $this->renderTwig('Master/Alumni:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Alumni entity.
     *
     */
    public function createAction()
    {
        $entity  = new Alumni();

        $request = $this->getRequest();
        $form    = $this->createForm(new AlumniType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'alumni_edit', array('id' => $id)));
        }

        return $this->renderTwig('Master/Alumni:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Alumni entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Alumni')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new AlumniType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Alumni:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Alumni entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Alumni')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AlumniType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'alumni_edit', array('id' => $id)));
        }

        return $this->renderTwig('Master/Alumni:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Alumni entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Alumni')->find($id);
            $this->forward404UnlessExist($entity);

            $this->doctrineRemove($entity);
        }

        return $this->redirect($this->generateUrl('alumni'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Alumni entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

