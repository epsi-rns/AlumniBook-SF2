<?php

namespace Iluni\BookBundle\Form\Filter;

use Symfony\Component\Form\FormBuilderInterface;

use Iluni\BookBundle\Form\Filter\AddressFilter;

/**
 * Form type for used with Filter controller
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OAddressFilter extends AddressFilter
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $order_by_choices = array(
            6  => 'ID',
            23 => 'Name (Organization/ Company)',
        );
        self::$order_by_choices = $order_by_choices + self::$order_by_choices;

        parent::buildForm($builder, $options);
        // $builder->add(...
    }

    public function getName()
    {
        return 'iluni_bookbundle_oaddressfilter';
    }
}

