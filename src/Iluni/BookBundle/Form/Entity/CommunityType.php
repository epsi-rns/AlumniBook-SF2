<?php

namespace Iluni\BookBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use Iluni\BookBundle\Form\EventListener\NarrowDepartmentEditFieldSubscriber;

/**
 * Form type for used with CRUD controller (entity operation)
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Bug: altered field order moved to the top
        // $subscriber = new NarrowDepartmentEditFieldSubscriber($builder->getFormFactory());
        // $builder->addEventSubscriber($subscriber);

        $builder
            ->add('name')
            ->add('brief')
            ->add('typeId', 'choice', array(
                'choices'   => array(
                    1 => 'Academic Formal',
                    2 => 'Student Club'
                ),
                'label' => 'Type'
            ))

            ->add('program', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Program',
                'empty_value' => false,
            ))
            ->add('faculty', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Faculty',
                'empty_value' => false,
            ))
            /*->add('department', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Department',
                'empty_value' => false,
            ))*/
            ->add('department', 'partial_department_choice', array(
                'master_index' => 0
            ))
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle'  => '@IluniBookBundle',
                'entity'  => 'Iluni\BookBundle\Entity\Alumni',
                'include' => array(
                    'program'    => 'required',
                    'department' => 'required',
                    'faculty'    => 'required',
                )
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
        return 'iluni_bookbundle_communitytype';
    }
}

