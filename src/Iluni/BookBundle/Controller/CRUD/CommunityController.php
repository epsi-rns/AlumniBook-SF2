<?php

namespace Iluni\BookBundle\Controller\CRUD;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Iluni\BookBundle\Library\Controller\CommonCRUDController;
use Iluni\BookBundle\Entity\Community;
use Iluni\BookBundle\Form\Entity\CommunityType;

use Iluni\BookBundle\Library\LD3\DepartmentEditLD3;

/**
 * Community CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityController extends CommonCRUDController
{
    public function showAction($id)
    {
        $entity = $this->getRepository('Community')->find($id);
        $this->forward404UnlessExist($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Community:show', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Utility for testing purpose used by crawler
     *
     */
    public function firstAction($_format)
    {
        $id = $this->getRepository('Community')->getFirstId();

        $bags = array('id'=>$id);

        if ($_format=='json') {
            $response = new Response(json_encode($bags));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $action = 'IluniBookBundle:CRUD\Community:show';
            return $this->forward($action, $bags);
        }
    }

    public function newAction()
    {
        $entity = new Community();
        $form   = $this->createForm(new CommunityType(), $entity);

        $ld3 = new DepartmentEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('community', $entity);

        return $this->renderTwig('Master/Community:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function createAction()
    {
        $entity  = new Community();

        $request = $this->getRequest();
        $form    = $this->createForm(new CommunityType(), $entity);
        $form->bind($request);

        if ($this->isValid($form)) {
            $this->doctrinePersist($entity);
            $id = $entity->getId();
            return $this->redirect($this->generateUrl(
                'community_edit', array('id' => $id)));
        }

        return $this->renderTwig('Master/Community:form', array(
            'entity' => $entity,
            'edit_form'   => $form->createView()
        ));
    }

    public function editAction($id)
    {
        $entity = $this->getRepository('Community')->find($id);
        $this->forward404UnlessExist($entity);

        $ld3 = new DepartmentEditLD3($this);
        $JSOptions = $ld3->getJavascriptOptions('community', $entity);

        $editForm = $this->createForm(new CommunityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderTwig('Master/Community:form', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ld3' => $JSOptions
        ));
    }

    public function updateAction($id)
    {
        $entity = $this->getRepository('Community')->find($id);
        $this->forward404UnlessExist($entity);

        $editForm   = $this->createForm(new CommunityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $editForm->bind($request);

        if ($this->isValid($editForm)) {
            $this->doctrinePersist($entity);
            return $this->redirect($this->generateUrl(
                'community_edit', array('id' => $id)));
        }

        return $this->renderTwig('Master/Community:form', array(
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
            $entity = $this->getRepository('Community')->find($id);
            $this->forward404UnlessExist($entity);

            $this->doctrineRemove($entity);

            return $this->redirect($this->generateUrl('community'));
        }

        return $this->redirect($this->generateUrl('community'));
    }

    private function forward404UnlessExist(&$entity)
    {
        if (!$entity) {
            $message = 'Unable to find Community entity.';
            throw $this->createNotFoundException($message);
        }
    }
}

