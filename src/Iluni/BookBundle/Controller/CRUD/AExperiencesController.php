<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniExperiences;
use Iluni\BookBundle\Form\Entity\AExperiencesType;

/**
 * AExperiences CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AExperiencesController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniExperiences')
            ->findBy(array('alumni' => $aid));
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniExperiences:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    /**
     * Finds and displays a AExperiences entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniExperiences')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniExperiences:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new AExperiences entity.
     *
     */
    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity = new AlumniExperiences();
        $entity->setAlumni($alumni);
        $form   = $this->createForm(new AExperiencesType(), $entity);

        return $this->renderTwig('Detail/AlumniExperiences:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new AExperiences entity.
     *
     */
    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniExperiences();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new AExperiencesType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'aexperiences_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniExperiences:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing AExperiences entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniExperiences')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new AExperiencesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniExperiences:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing AExperiences entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniExperiences')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AExperiencesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'aexperiences_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniExperiences:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AExperiences entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\AlumniExperiences')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'aexperiences_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('aexperiences'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AlumniExperiences entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

