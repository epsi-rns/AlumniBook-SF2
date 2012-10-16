<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\OrgContacts;
use Iluni\BookBundle\Form\Entity\ContactType;

/**
 * OContacts CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OContactsController extends CommonCRUDController
{
    public function listAction($oid)
    {
        $entities = $this
            ->getRepository('Detail\OrgContacts')
            ->findList($oid);
        $org = $this->getOrganization($oid);

        return $this->renderTwig('Detail/OrgContacts:list', array(
            'entities' => $entities,
            'organization' => $org
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\OrgContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgContacts:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity = new OrgContacts();
        $entity->setOrganization($org);
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->renderTwig('Detail/OrgContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function createAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity  = new OrgContacts();
        $entity->setOrganization($org);

        $request = $this->getRequest();
        $form    = $this->createForm(new ContactType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'ocontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\OrgContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgContacts:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\OrgContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'ocontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgContacts:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\OrgContacts')->find($id);
            $this->forward404UnlessExist($entity);

            $oid = $entity->getOrganization()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'ocontacts_list', array('oid' => $oid)));
        }

        return $this->redirect($this->generateUrl('ocontacts'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Contact entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

