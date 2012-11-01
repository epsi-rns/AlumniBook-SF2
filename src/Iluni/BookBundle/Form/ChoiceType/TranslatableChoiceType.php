<?php
// Better alternative:
// https://github.com/liip/LiipFormTranslationChoiceBundle
// https://github.com/liip/LiipFormTranslationChoiceBundle/blob/master/Form/Type/TranslationChoiceType.php

namespace Iluni\BookBundle\Form\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Doctrine\ORM\EntityManager;

use Iluni\BookBundle\Form\ChoiceList\TranslatableEntityLoader;

/**
 * Field type that handle translatable choice.
 * Using gedmo approach display translatable entity.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class TranslatableChoiceType extends AbstractType
{
    protected $entityManager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entityManager = $entity_manager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $type = $this;

        $choice_list = function (Options $options) use ($type) {
            return $options['class']
                ? $type->getChoiceList($options)
                : null;
        };

        $resolver->setRequired(array(
            'class'
        ));

        $resolver->setDefaults(array(
            // parent (choice) properties
            'choice_list'     => $choice_list,
            'required'    => false,
            'empty_value' => '----------',
            'empty_data'  => null,
            // optional properties
            'query_find'  => null,
            // unused experimental
            //'query_key'     => 'id',
            //'query_value' => 'name',  // alias=property
        ));
    }

    protected function getEntityLoader(Options $options)
    {
        return new TranslatableEntityLoader(
            $this->entityManager,
            $options['class'],
            $options
        );

        return $loader;
    }

    protected function getChoiceList(Options $options)
    {
        $loader = $this->getEntityLoader($options);

        return new EntityChoiceList(
            $this->entityManager,
            $options['class'],
            null,
            $loader
        );
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'translatable_choice';
    }
}

