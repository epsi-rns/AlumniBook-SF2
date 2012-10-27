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
class ACommunitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $query_builder = function (EntityRepository $repository) {
            return $repository->createQueryBuilder('r')->orderBy('r.id');
        };

        $builder
            ->add('community', 'lookupmodal', array(
                'class' => 'Iluni\BookBundle\Entity\Community',
                'link_text' => 'Pick Community',
                'link_title' => 'Lookup Community Name',
                'link_route' => 'modal_community'
            ))
            ->add('classYear', 'integer', array(
                'label'  => 'Class of (year)'
            ))
            ->add('classSub', 'text', array(
                'label'  => 'Subclass',
                'required' => false
            ))
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Detail\AlumniCommunities',
                'include' => array(
                    'community_name'    => 'required'
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
        return 'iluni_bookbundle_acommunitiestype';
    }
}

