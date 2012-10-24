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
class BirthdayFilter extends AbstractType
{
    protected static $order_by_choices = array(
        1  => 'ID',
        28 => 'Name',
        73  => 'Date: Birthdate',
        74  => 'Date: Day',
        75  => 'Date: Month',
        76  => 'Date: Year',
        77  => 'Date: Weekday',
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
            // ...
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
        return 'iluni_bookbundle_birthdayfilter';
    }
}

