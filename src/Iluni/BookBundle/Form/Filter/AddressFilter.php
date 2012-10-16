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
class AddressFilter extends AbstractType
{
    protected static $order_by_choices = array(
        60 => 'Address',
        61 => 'Region',
        63 => 'Code: Country',
        64 => 'Code: Province',
        65 => 'Code: District',
        66 => 'Postal Code',
        67 => 'Street',
        68 => 'Area',
        69 => 'Building'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain'     => 'forms',
        ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_addressfilter';
    }
}

