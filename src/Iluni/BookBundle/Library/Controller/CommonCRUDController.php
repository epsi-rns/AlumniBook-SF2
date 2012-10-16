<?php

namespace Iluni\BookBundle\Library\Controller;

/**
 * Common CRUD controller.
 *
 */
class CommonCRUDController extends CommonController
{
    protected function isValid($form)
    {
        $state = $form->isValid();
        if (!$state) {
            $this
                ->get('session')
                ->getFlashBag()
                ->add('error', 'Not saved! Please verify entry.');
        }

        return $state;
    }

    // CRUD Helper for create and update
    protected function doctrinePersist($entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        $this
            ->get('session')
            ->getFlashBag()
            ->add('info', 'Saved successfully');
    }

    // CRUD Helper for delete
    protected function doctrineRemove($entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($entity);
        $em->flush();

        $this
            ->get('session')
            ->getFlashBag()
            ->add('notice', 'Deleted successfully');
    }

    protected function createDeleteForm($id)
    {
        return $this
            ->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }

    // CRUD Helper for create and update
    protected function processForm($form, $entity, $url)
    {
        // better not to implement, may confused logical flow
    }

    // This should be a trait
    protected function getAlumni($aid)
    {
        $entity = $this->getRepository('Alumni')->find($aid);

        if (!$entity) {
            $message = 'Unable to find Alumni entity.';
            throw $this->createNotFoundException($message);
        }

        return $entity;
    }

    // This should be a trait
    protected function getOrganization($oid)
    {
        $entity = $this->getRepository('Organization')->find($oid);

        if (!$entity) {
            $message = 'Unable to find Organization entity.';
            throw $this->createNotFoundException($message);
        }

        return $entity;
    }

    // This should be a trait
    protected function getMap($mid)
    {
        $entity = $this->getRepository('Detail\AlumniOrgMap')->find($mid);

        if (!$entity) {
            $message = 'Unable to find Map entity.';
            throw $this->createNotFoundException($message);
        }

        return $entity;
    }
}

