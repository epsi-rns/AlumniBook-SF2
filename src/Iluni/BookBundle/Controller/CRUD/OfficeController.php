<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\OrgAddress;
use Iluni\BookBundle\Form\Entity\AddressType;

use Iluni\BookBundle\Library\LD3\DistrictEditLD3;

/**
 * Office CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OfficeController extends CommonCRUDController
{
    public function listAction($oid)
    {
        $entities = $this
            ->getRepository('Detail\OrgAddress')
            ->findBy(array('organization' => $oid));
        $org = $this->getOrganization($oid);

        return $this->renderTwig('Detail/OrgAddress:list', array(
            'entities' => $entities,
            'organization' => $org
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\OrgAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgAddress:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($oid)
    {
        $org = $this->getOrganization($oid);
        $country = $this->getDefaultCountry();

        $entity = new OrgAddress();
        $entity->setOrganization($org);
        $entity->setCountry($country);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $form   = $this->createForm(new AddressType(), $entity);

        return $this->renderTwig('Detail/OrgAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function createAction($oid)
    {
        $org = $this->getOrganization($oid);

        $entity  = new OrgAddress();
        $entity->setOrganization($org);

        $request = $this->getRequest();
        $form    = $this->createForm(new AddressType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'office_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\OrgAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $editForm = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/OrgAddress:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\OrgAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'office_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/OrgAddress:form', array(
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
            $entity = $this->getRepository('Detail\OrgAddress')->find($id);
            $this->forward404UnlessExist($entity);

            $oid = $entity->getOrganization()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'office_list', array('oid' => $oid)));
        }

        return $this->redirect($this->generateUrl('office'));
    }

    protected function getDefaultCountry()
    {
        $entity = $this->getRepository('Category\Country')->find(99);

        if (!$entity) {
            throw $this->createNotFoundException(
                'Unable to find Default Country entity.');
        }

        return $entity;
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Address entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

