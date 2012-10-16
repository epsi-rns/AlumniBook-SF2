<?php
namespace Iluni\BookBundle\Form\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Iluni\BookBundle\Library\OptionsHolder\OptionsHolder;

/**
 * Field type that handle ajax choice.
 * Based on partial translatabe choice.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class PartialDistrictChoiceType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // district linked property
        $resolver->setDefaults(array(
                'translation_domain'     => 'forms',
                // required properties
                'class' => 'IluniBookBundle:Category\District',
                'master_name' => 'province',
                // overidden properties
                'empty_message1' => '-- please select province first --',
                'empty_message2' => '-- all districts in this province --'
            ));
    }

    public function getParent()
    {
        return 'partial_choice';
    }
    public function getName()
    {
        return 'partial_district_choice';
    }
}

