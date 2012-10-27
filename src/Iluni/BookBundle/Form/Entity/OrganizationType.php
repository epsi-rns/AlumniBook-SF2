<?php

namespace Iluni\BookBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form type for used with CRUD controller (entity operation)
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('prefix')
            ->add('suffix')
            ->add('parent', 'lookupmodal', array(
                'class' => 'Iluni\BookBundle\Entity\Organization',
                'link_text' => 'Pick Organization/ Company',
                'link_title' => 'Lookup Organization/ Company Name',
                'link_route' => 'modal_org'
            ))
            ->add('note')
            //->add('fullname')
            //->add('createdAt')
            //->add('updatedAt')
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Organization'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain'     => 'forms',
        ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_organizationtype';
    }
}

