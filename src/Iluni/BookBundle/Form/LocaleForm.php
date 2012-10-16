<?php

namespace Iluni\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LocaleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale', 'choice', array(
                'choices'   => array('en'=>'English', 'id'=>'Indonesia'),
                'empty_value' => false,
                'label' => 'Choose a language:'
            ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_localeform';
    }
}

