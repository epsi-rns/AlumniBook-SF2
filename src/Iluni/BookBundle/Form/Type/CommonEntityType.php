<?php
namespace Iluni\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Reusable shortcut for filtering purpose.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommonEntityType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $query_builder = function (EntityRepository $repository) {
            return $repository->createQueryBuilder('r')->orderBy('r.id');
        };

        $resolver->setDefaults(array(
            'property' => 'name',
            'query_builder' => $query_builder,
            'required'  => false,
            'empty_value' => '----------',
            'empty_data'  => null
        ));
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'category';
    }
}

