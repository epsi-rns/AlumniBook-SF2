<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Detail\AlumniOrgMap;
use Iluni\BookBundle\Form\Entity\AMapType;

/**
 * Organization CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AMapController extends CommonCRUDController
{
    public function listAction($aid)
    {
        $entities = $this
            ->getRepository('Detail\AlumniOrgMap')
            ->findAlumniList($aid);
        $alumni = $this->getAlumni($aid);

        return $this->renderTwig('Detail/AlumniMap:list', array(
            'entities' => $entities,
            'alumni' => $alumni
        ));
    }

    public function showAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        return $this->renderTwig('Detail/AlumniMap:show', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Utility for testing purpose used by crawler
     *
     */
    public function firstAction($_format)
    {
        $id = $this->getRepository('Detail\AlumniOrgMap')->getFirstId();

        $bags = array('mid'=>$id);

        if ($_format=='json') {
            $response = new Response(json_encode($bags));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $action = 'IluniBookBundle:CRUD\AMap:show';
            return $this->forward($action, $bags);
        }
    }

    public function newAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity = new AlumniOrgMap();
        $entity->setAlumni($alumni);
        $form   = $this->createForm(new AMapType(), $entity);

        return $this->renderTwig('Detail/AlumniMap:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function createAction($aid)
    {
        $alumni = $this->getAlumni($aid);

        $entity  = new AlumniOrgMap();
        $entity->setAlumni($alumni);

        $request = $this->getRequest();
        $form    = $this->createForm(new AMapType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'amap_edit', array('mid' => $id)));
        }

        return $this->renderTwig('Detail/AlumniMap:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        $editForm = $this->createForm(new AMapType(), $entity);
        $deleteForm = $this->createDeleteForm($mid);

        return $this->renderTwig('Detail/AlumniMap:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updateAction($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new AMapType(), $entity);
        $deleteForm = $this->createDeleteForm($mid);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'amap_edit', array('mid' => $mid)));
        }

        return $this->renderTwig('Detail/AlumniMap:form', array(
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

            $aid = $entity->getAlumni()->getId();
            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl(
                'amap_list', array('aid' => $aid)));
        }

        return $this->redirect($this->generateUrl('alumni'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find AOMap entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

