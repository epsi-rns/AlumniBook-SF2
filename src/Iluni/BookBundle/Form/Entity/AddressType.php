<?php

namespace Iluni\BookBundle\Form\Entity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use Iluni\BookBundle\Form\EventListener\NarrowDistrictEditFieldSubscriber;

/**
 * Form type for used with CRUD controller (entity operation)
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Bug: altered field order moved to the top
        // $subscriber = new NarrowDistrictEditFieldSubscriber($builder->getFormFactory());
        // $builder->addEventSubscriber($subscriber);

        $query_builder = function (EntityRepository $repository) {
            return $repository->createQueryBuilder('r')->orderBy('r.id');
        };

        $builder
            ->add('area')
            ->add('building')
            ->add('street')
            ->add('country', 'entity', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Country',
                'property' => 'name',
                'empty_value' => '-- Select Country --',
                'required' => false,
                'query_builder' => $query_builder,
                // this need a test since introducing BC break in 2.1
                //'preferred_choices' => array(99) // hardcoded default value
            ))
            ->add('province', 'entity', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Province',
                'property' => 'name',
                'empty_value' => '-- Select Province --',
                'required' => false,
                'query_builder' => $query_builder,
            ))
            ->add('district', 'partial_district_choice', array(
                'master_index' => 0
            ))
            /*
            ->add('district', 'entity', array(
                'class' => 'Iluni\BookBundle\Entity\Category\District',
                'property' => 'name',
                'empty_value' => '-- Select District --',
                'required' => false,
                'query_builder' => $query_builder,
            ))
            */
            ->add('postalCode', 'text', array(
                'label'  => 'Postal Code',
                'required' => false
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
        return 'iluni_bookbundle_addresstype';
    }
}

