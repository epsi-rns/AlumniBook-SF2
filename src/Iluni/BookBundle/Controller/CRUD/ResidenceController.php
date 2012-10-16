<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniAddress;
use Iluni\BookBundle\Form\Entity\AddressType;

use Iluni\BookBundle\Library\LD3\DistrictEditLD3;

/**
 * Residence CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ResidenceController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniAddress')
            ->findBy(array('alumni' => $aid));
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniAddress:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniAddress:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);
        $country = $this->getDefaultCountry();

        $entity = new AlumniAddress();
        $entity->setAlumni($alumni);
        $entity->setCountry($country);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $form   = $this->createForm(new AddressType(), $entity);

        return $this->renderTwig('Detail/AlumniAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniAddress();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new AddressType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'residence_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniAddress:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $ld3 = new DistrictEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('address', $entity);

        $editForm = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniAddress:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniAddress')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'residence_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniAddress:form', array(
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
            $entity = $this->getRepository('Detail\AlumniAddress')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'residence_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('residence'));
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

