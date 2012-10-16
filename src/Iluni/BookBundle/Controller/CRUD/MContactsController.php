<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\MapContacts;
use Iluni\BookBundle\Form\Entity\ContactType;

/**
 * MContacts CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class MContactsController extends CommonCRUDController
{
    public function listAction($mid)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities   = $em->getRepository(
            'IluniBookBundle:Detail\MapContacts'
        )->findList($mid);
        $map        = $em->getRepository(
            'IluniBookBundle:Detail\AlumniOrgMap'
        )->find($mid);

        return $this->renderTwig('Detail/MapContacts:list', array(
            'entities' => $entities,
            'map' => $map
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\MapContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/MapContacts:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($mid)
    {
        $map = $this->getMap($mid);

        $entity = new MapContacts();
        $entity->setAlumniOrgMap($map);
        $form   = $this->createForm(new ContactType(), $entity);

        return $this->renderTwig('Detail/MapContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function createAction($mid)
    {
        $map = $this->getMap($mid);

        $entity  = new MapContacts();
        $entity->setAlumniOrgMap($map);

        $request = $this->getRequest();
        $form    = $this->createForm(new ContactType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'mcontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/MapContacts:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\MapContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/MapContacts:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\MapContacts')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ContactType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'mcontacts_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/MapContacts:form', array(
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
            $entity = $this->getRepository('Detail\MapContacts')->find($id);
            $this->forward404UnlessExist($entity);

            $mid = $entity->getAlumniOrgMap()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'mcontacts_list', array('mid' => $mid)));
        }

        return $this->redirect($this->generateUrl('mcontacts'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Contact entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

