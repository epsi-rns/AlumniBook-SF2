<?php
namespace Iluni\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Iluni\BookBundle\Form\EventListener\NarrowDepartmentFilterFieldSubscriber;

/**
 * Subform type in filter controller.
 * It holds community fields together as groups.
 * It is called in every alumni attribute like:
 * - competency, experience, degree, certification, address, contact
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityFormType extends AbstractType
{
    protected static $decade_choices = array(
        1960 => '196x',
        1970 => '197x',
        1980 => '198x',
        1990 => '199x',
        2000 => '200x',
        2010 => '201x'
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new NarrowDepartmentFilterFieldSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);

        $builder
            ->add('program', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Program',
                'empty_value' => '-- All Programs --'
            ))
            ->add('faculty', 'translatable_choice', array(
                'class' => 'Iluni\BookBundle\Entity\Category\Faculty',
                'empty_value' => '-- All Faculties --'
            ))
            ->add('department', 'partial_department_choice', array(
                'master_index' => 0
            ))
            ->add('classYear', 'text', array(
                'label'  => 'Class of (year)',
                'required'  => false
            ))
            ->add('decade', 'choice', array(
                'choices'   => self::$decade_choices,
                'label'  => 'Decade',
                'required'  => false,
                'empty_value' => '-- All Classes --',
                'empty_data'  => null
            ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'community_holder';
    }
}

