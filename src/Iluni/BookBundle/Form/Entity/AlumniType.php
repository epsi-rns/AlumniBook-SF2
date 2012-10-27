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
class AlumniType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $query_builder = function (EntityRepository $repository) {
            return $repository->createQueryBuilder('r')->orderBy('r.id');
        };

        $builder
            ->add('name')
            ->add('prefix')
            ->add('suffix')
            ->add('gender', 'choice', array(
                'choices'   => array('M' => 'Male', 'F' => 'Female'),
                'required'  => false,
                'empty_value' => '-- Unknown --',
                'empty_data'  => null
            ))
            ->add('birthplace', 'text', array(
                'label'  => 'Birth Place',
                'required' => false
            ))
            ->add('birthdate', 'birthday', array(
                'label'  => 'Birth Date',
                'required' => false,
                'years' => range(1940, 2000),
            ))
            ->add('religion', 'entity', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Religion',
                'property' => 'name',
                'empty_value' => '-- Select Religion --',
                'required' => false,
                'query_builder' => $query_builder,
            ))
            ->add('note')
            //->add('fullname')
            //->add('createdAt')
            //->add('updatedAt')
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Alumni'
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
        return 'iluni_bookbundle_alumnitype';
    }
}

