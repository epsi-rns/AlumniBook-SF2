<?php

namespace Iluni\BookBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Form type for used with CRUD controller (entity operation)
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AMapType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organization', 'lookupmodal', array(
                'class' => 'Iluni\BookBundle\Entity\Organization',
                'link_text'  => 'Pick Organization/ Company',
                'link_title' => 'Lookup Organization/ Company Name',
                'link_route' => 'modal_org'
            ))
            ->add('department')
            ->add('description')
            ->add('struktural')
            ->add('fungsional')
            ->add('jobType', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\JobType',
                'empty_value' => '-- Select Occupation --',
                'required' => false,
                'label'  => 'Occupation'
            ))
            ->add('jobPosition', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\JobPosition',
                'empty_value' => '-- Select Job Position --',
                'required' => false,
                'label'  => 'Job Position'
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
        return 'iluni_bookbundle_amaptype';
    }
}

