<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\MapAddress;
use Iluni\BookBundle\Form\Entity\AddressType;

use Iluni\BookBundle\Library\LD3\DistrictEditLD3;

/**
 * Workplace CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class WorkplaceController extends CommonCRUDController
{
    public function listAction($mid)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities   = $em
            ->getRepository('IluniBookBundle:Detail\MapAddress')
            ->findBy(array('alumni_org_map' => $mid));
        $map        = $em
            ->getRepository('IluniBookBundle:Detail\AlumniOrgMap')
            ->find($mid);

        return $this->renderTwig('Detail/MapAddress:list', array(
            'entities' => $entities,
            'map' => $map
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\MapAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/MapAddress:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($mid)
    {
        $map = $this->getMap($mid);
        $country = $this->getDefaultCountry();

        $entity = new MapAddress();
        $entity->setAlumniOrgMap($map);
        $entity->setCountry($country);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $form   = $this->createForm(new AddressType(), $entity);

        return $this->renderTwig('Detail/MapAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function createAction($mid)
    {
        $map = $this->getMap($mid);

        $entity  = new MapAddress();
        $entity->setAlumniOrgMap($map);

        $request = $this->getRequest();
        $form    = $this->createForm(new AddressType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'workplace_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/MapAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\MapAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $editForm = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/MapAddress:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\MapAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'workplace_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/MapAddress:form', array(
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
            $entity = $this->getRepository('Detail\MapAddress')->find($id);
            $this->forward404UnlessExist($entity);

            $mid = $entity->getAlumniOrgMap()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'workplace_list', array('mid' => $mid)));
        }

        return $this->redirect($this->generateUrl('workplace'));
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

