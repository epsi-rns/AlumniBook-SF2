<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniOrgMap;
use Iluni\BookBundle\Form\Entity\OMapType;

/**
 * Organization CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OMapController extends CommonCRUDController
{
    public function listAction($oid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findOrgList($oid);
        $org = $this->getOrganization($oid);

        return $this->renderTwig('Detail/OrgMap:list', array(
            'entities' => $entities,
            'organization' => $org
        ));
    }

    public function showAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        return $this->renderTwig('Detail/OrgMap:show', array(
            'entity'      => $entity,
        ));
    }

    public function newAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity = new AlumniOrgMAp();
        $entity->setOrganization($org);
        $form   = $this->createForm(new OMapType(), $entity);

        return $this->renderTwig('Detail/OrgMap:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function createAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity  = new AlumniOrgMap();
        $entity->setOrganization($org);

        $request = $this->getRequest();
        $form    = $this->createForm(new OMapType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'omap_edit', array('mid' => $id)));
        }

        return $this->renderTwig('Detail/OrgMap:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new OMapType(), $entity);
        $deleteForm = $this->createDeleteForm($mid);

        return $this->renderTwig('Detail/OrgMap:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new OMapType(), $entity);
        $deleteForm = $this->createDeleteForm($mid);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'omap_edit', array('mid' => $mid)));
        }

        return $this->renderTwig('Detail/OrgMap:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($mid)
    {
        $form = $this->createDeleteForm($mid);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
            $this->forward404UnlessExist($entity);

            $oid = $entity->getOrganization()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'omap_list', array('oid' => $oid)));
        }

        return $this->redirect($this->generateUrl('org'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AOMap entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

