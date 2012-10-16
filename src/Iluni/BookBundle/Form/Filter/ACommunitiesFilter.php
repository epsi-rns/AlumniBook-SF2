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
class ACommunitiesFilter extends AbstractType
{
    protected static $order_by_choices = array(
        1  => 'ID',
        21 => 'Name',
        81 => 'Community',
        82 => 'Department',
        83 => 'Faculty',
        84 => 'Program',
        85 => 'Class of (year)'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices))
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
        return 'iluni_bookbundle_acommunitiesfilter';
    }
}

