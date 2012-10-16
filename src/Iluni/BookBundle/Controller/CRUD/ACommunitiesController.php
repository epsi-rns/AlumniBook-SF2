<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniCommunities;
use Iluni\BookBundle\Form\Entity\ACommunitiesType;

/**
 * ACommunities CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACommunitiesController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniCommunities')
            ->findList($aid);
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniCommunities:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    /**
     * Finds and displays a ACommunities entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCommunities')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniCommunities:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new ACommunities entity.
     *
     */
    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity = new AlumniCommunities();
        $entity->setAlumni($alumni);
        $form   = $this->createForm(new ACommunitiesType(), $entity);

        return $this->renderTwig('Detail/AlumniCommunities:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Creates a new ACommunities entity.
     *
     */
    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniCommunities();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new ACommunitiesType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'acommunities_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniCommunities:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing ACommunities entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCommunities')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new ACommunitiesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Detail/AlumniCommunities:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing ACommunities entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->getRepository('Detail\AlumniCommunities')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new ACommunitiesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'acommunities_edit', array('id' => $id)));
        }

        return $this->renderTwig('Detail/AlumniCommunities:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ACommunities entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->getRepository('Detail\AlumniCommunities')->find($id);
            $this->forward404UnlessExist($entity);

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'acommunities_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('acommunities'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AlumniCommunities entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

