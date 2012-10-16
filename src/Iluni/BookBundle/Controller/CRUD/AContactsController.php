<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniContacts;
use Iluni\BookBundle\Form\Entity\ContactType;

/**
 * AContacts CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AContactsController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniContacts')
            ->findList($aid);
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniContacts:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniContacts:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity = new AlumniContacts();
        $entity->setAlumni($alumni);
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->renderTwig('Detail/AlumniContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniContacts();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new ContactType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'acontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniContacts:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'acontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniContacts:form', array(
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
            $entity = $this->getRepository('Detail\AlumniContacts')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'acontacts_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('acontacts'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Contact entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

