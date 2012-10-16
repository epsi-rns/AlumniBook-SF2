<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniCompetencies;
use Iluni\BookBundle\Form\Entity\ACompetenciesType;

/**
 * ACompetencies CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACompetenciesController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniCompetencies')
            ->findList($aid);
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniCompetencies:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    /**
     * Finds and displays a ACompetencies entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCompetencies')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniCompetencies:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new ACompetencies entity.
     *
     */
    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity = new AlumniCompetencies();
        $entity->setAlumni($alumni);
        $form   = $this->createForm(new ACompetenciesType(), $entity);

        return $this->renderTwig('Detail/AlumniCompetencies:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new ACompetencies entity.
     *
     */
    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniCompetencies();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new ACompetenciesType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'acompetencies_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniCompetencies:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing ACompetencies entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCompetencies')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ACompetenciesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniCompetencies:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing ACompetencies entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCompetencies')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ACompetenciesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'acompetencies_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniCompetencies:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ACompetencies entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\AlumniCompetencies')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'acompetencies_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('acompetencies'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AlumniCompetencies entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

