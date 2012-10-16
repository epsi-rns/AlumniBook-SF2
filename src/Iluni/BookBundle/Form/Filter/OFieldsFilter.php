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
class OFieldsFilter extends AbstractType
{
    protected static $order_by_choices = array(
        3  => 'ID',
        23 => 'Organization/ Company',
        30 => 'Product',
        46 => 'Business Field'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices,
                'preferred_choices' => array(46)
            ))
            ->add('bizField', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\BizField',
                'label'  => 'Business Field',
                'empty_value' => '-- All Business Fields --'
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
        return 'iluni_bookbundle_ofieldsfilter';
    }
}

