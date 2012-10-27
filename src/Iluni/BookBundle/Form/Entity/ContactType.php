<?php

namespace Iluni\BookBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Form type for used with CRUD controller (entity operation)
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactType', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\ContactType',
                'empty_value' => false,
                'label'  => 'Contact Type'
            ))
            ->add('contact')
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Base\Contacts'
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
        return 'iluni_bookbundle_contacttype';
    }
}

