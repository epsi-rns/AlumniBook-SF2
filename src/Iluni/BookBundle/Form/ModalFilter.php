<?php

namespace Iluni\BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ModalFilter extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label'  => 'Name Like %',
                'required' => false
            ));
    }

    public function getName()
    {
        return 'iluni_bookbundle_modalfilter';
    }
}

