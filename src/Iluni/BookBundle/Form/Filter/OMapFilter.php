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
class OMapFilter extends AbstractType
{
    protected static $order_by_choices = array(
        4 => 'ID',
        21 => 'Name (Alumna/us)',
        23 => 'Name (Organization/ Company)',
        101 => 'Community',
        102 => 'Department',
        103 => 'Faculty',
        104 => 'Program',
        105 => 'Class of (year)'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderBy', 'order_by', array(
                'choices'   => self::$order_by_choices,))
            ->add('jobPosition', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\JobPosition',
                'label'  => 'Job Position',
                'empty_value' => '-- All Job Positions --'
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
        return 'iluni_bookbundle_omapfilter';
    }
}

