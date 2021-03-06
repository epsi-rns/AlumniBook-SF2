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
class AExperiencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('alumni', 'hidden')
            ->add('organization')
            ->add('description')
            ->add('jobPosition', 'text', array(
                'label'  => 'Job Position',
                'required' => false
            ))
            ->add('yearIn', 'integer', array(
                'label'    => 'Year in',
                'required' => false
            ))
            ->add('yearOut', 'integer', array(
                'label'  => 'Year out',
                'required' => false
            ))
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Detail\AlumniExperiences'
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
        return 'iluni_bookbundle_aexperiencestype';
    }
}

