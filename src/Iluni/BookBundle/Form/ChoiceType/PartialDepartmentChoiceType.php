<?php
namespace Iluni\BookBundle\Form\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Iluni\BookBundle\Library\OptionsHolder\FilterOptionsHolder;

/**
 * Field type that handle ajax choice.
 * Based on partial translatabe choice.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class PartialDepartmentChoiceType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // department linked property
        $resolver->setDefaults(array(
                'translation_domain'     => 'forms',
                // required properties
                'class' => 'IluniBookBundle:Category\Department',
                'master_name' => 'faculty',
                // overidden properties
                'empty_message1' => '-- please select faculty first --',
                'empty_message2' => '-- all departments in this faculty --'
            ));
    }

    public function getParent()
    {
        return 'partial_choice';
    }
    public function getName()
    {
        return 'partial_department_choice';
    }
}

