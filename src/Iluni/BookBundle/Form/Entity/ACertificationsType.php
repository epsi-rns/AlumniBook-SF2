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
class ACertificationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('certification')
            ->add('institution')
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Detail\AlumniCertifications'
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
        return 'iluni_bookbundle_acertificationstype';
    }
}

