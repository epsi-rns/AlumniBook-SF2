<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\OrgFields;
use Iluni\BookBundle\Form\Entity\OFieldsType;

/**
 * OFields CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OFieldsController extends CommonCRUDController
{
    public function listAction($oid)
    {
        $entities = $this
            ->getRepository('Detail\OrgFields')
            ->findList($oid);
        $org = $this->getOrganization($oid);

        return $this->renderTwig('Detail/OrgFields:list', array(
            'entities' => $entities,
            'organization' => $org
        ));
    }

    /**
     * Finds and displays a OFields entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\OrgFields')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgFields:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new OFields entity.
     *
     */
    public function newAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity = new OrgFields();
        $entity->setOrganization($org);
        $form   = $this->createForm(new OFieldsType(), $entity);

        return $this->renderTwig('Detail/OrgFields:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new OFields entity.
     *
     */
    public function createAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity  = new OrgFields();
        $entity->setOrganization($org);

        $request = $this->getRequest();
        $form    = $this->createForm(new OFieldsType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'ofields_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgFields:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing OFields entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\OrgFields')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new OFieldsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgFields:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing OFields entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\OrgFields')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new OFieldsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'ofields_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgFields:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OFields entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\OrgFields')->find($id);
            $this->forward404UnlessExist($entity);

            $oid = $entity->getOrganization()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'ofields_list', array('oid' => $oid)));
        }

        return $this->redirect($this->generateUrl('ofields'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find OrgFields entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

