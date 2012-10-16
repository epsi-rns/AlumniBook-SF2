<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniDegrees;
use Iluni\BookBundle\Form\Entity\ADegreesType;

/**
 * ADegrees CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ADegreesController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniDegrees')
            ->findList($aid);
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniDegrees:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    /**
     * Finds and displays a ADegrees entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniDegrees')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniDegrees:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new ADegrees entity.
     *
     */
    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);
        $degree = $this->getDefaultDegree();

        $entity = new AlumniDegrees();
        $entity->setAlumni($alumni);
        $entity->setStrata($degree);

        $form   = $this->createForm(new ADegreesType(), $entity);

        return $this->renderTwig('Detail/AlumniDegrees:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new ADegrees entity.
     *
     */
    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniDegrees();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new ADegreesType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'adegrees_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniDegrees:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing ADegrees entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniDegrees')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ADegreesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniDegrees:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing ADegrees entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniDegrees')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ADegreesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'adegrees_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniDegrees:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ADegrees entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\AlumniDegrees')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'adegrees_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('adegrees'));
    }

    protected function getDefaultDegree()
    {
        $entity = $this->getRepository('Category\Strata')->find(10);

        if (!$entity) {
            throw $this->createNotFoundException(
                'Unable to find Default Degree entity.');
        }

        return $entity;
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AlumniDegrees entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

