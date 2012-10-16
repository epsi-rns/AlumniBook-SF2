<?php

namespace Iluni\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SummaryFilter extends AbstractType
{
    protected static $group_by_choices = array(
        1 => 'Community',
        2 => 'Department',
        3 => 'Faculty',
        4 => 'Program',
        5 => 'Class of (year)',
        6 => 'Detail Community'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupBy', 'order_by', array(
                'choices'   => self::$group_by_choices,
                'empty_data' => 1
            ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_summaryfilter';
    }
}

