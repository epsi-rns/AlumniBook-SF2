<?php

namespace Iluni\BookBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form type for used with Filter controller
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityFilter extends AbstractType
{
    protected static $order_by_choices = array(
        1  => 'ID',
        10  => 'Members Count',
        91 => 'Community',
        92 => 'Department',
        93 => 'Faculty',
        94 => 'Program'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices))
            ->add('program', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Program',
                'empty_value' => '-- All Programs --'
            ))
            ->add('faculty', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Faculty',
                'empty_value' => '-- All Faculties --'
            ))
            ->add('department', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Department',
                'empty_value' => '-- All Departments --'
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
        return 'iluni_bookbundle_communityfilter';
    }
}

