<?php
namespace Iluni\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Common field type that is used
 * to handle "order-by" select box in filter controller.
 *
 * The result will be used in doctrine query to display related table
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrderByType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label'  => 'Order by',
            'required'  => false,
            'empty_value' => '-- Default --',
            'empty_data'  => null
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'order_by';
    }
}

