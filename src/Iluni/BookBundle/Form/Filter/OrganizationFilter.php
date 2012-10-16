<?php

namespace Iluni\BookBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

use Iluni\BookBundle\Form\Type\CommunityFormType;

/**
 * Form type for used with Filter controller
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationFilter extends AbstractType
{
    protected static $order_by_choices = array(
        3  => 'ID',
        25 => 'Organization/ Company',
        11 => 'Created Time',
        12 => 'Updated Time'
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
        return 'iluni_bookbundle_organizationfilter';
    }
}

