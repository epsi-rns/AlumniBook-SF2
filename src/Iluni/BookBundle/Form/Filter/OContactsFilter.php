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
class OContactsFilter extends AbstractType
{
    protected static $order_by_choices = array(
        6  => 'ID',
        23 => 'Name (Organization/ Company)',
        47 => 'Contact Type'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices))
            ->add('contactType', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\ContactType',
                'label'  => 'Contact Type',
                'empty_value' => '-- All Kind of Contacts --'
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
        return 'iluni_bookbundle_ocontactsfilter';
    }
}

