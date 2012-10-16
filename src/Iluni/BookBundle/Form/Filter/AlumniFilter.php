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
class AlumniFilter extends AbstractType
{
    protected static $order_by_choices = array(
        1  => 'ID',
        24 => 'Name',
        11 => 'Created Time',
        12 => 'Updated Time',
        111 => 'Community',
        112 => 'Department',
        113 => 'Faculty',
        114 => 'Program',
        115 => 'Class of (year)'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices))
            ->add('name', 'text', array(
                'label'  => 'Name Like %',
                'required' => false
            ))
            ->add('update_st', 'datepicker', array(
                'label'  => 'Update (start) Range'
            ))
            ->add('update_nd', 'datepicker', array(
                'label'  => 'Update (end) Range'
            ))
            ->add('community', 'community_holder');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain'     => 'forms',
        ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_alumnifilter';
    }
}

