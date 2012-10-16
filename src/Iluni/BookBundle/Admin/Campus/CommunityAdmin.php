<?php

namespace Iluni\BookBundle\Admin\Campus;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array(
                'help'=>'This should be named manually'
            ))
            ->add('brief', null, array(
                'help'=>'Abbreviation or short name for this community in your culture'
            ))
            ->add('typeId', 'choice', array(
                'choices' => array(
                    1 => 'Academic Formal',
                    2 => 'Student Club'
                ),
                'label'=>'Type',
                'help'=>'Experimental...'
            ))
            ->add('program', null, array(
                'help'=>'Select program this community linked to'
            ))
            ->add('faculty', null, array(
                'help'=>'Select faculty this community linked to'
            ))
            ->add('department', null, array(
                'help'=>'Select department this community linked to'
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('program')
            ->add('faculty')
            ->add('department');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('program')
            ->addIdentifier('faculty')
            ->addIdentifier('department');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertMinLength(array('limit' => 3))
            ->assertMaxLength(array('limit' => 50))
            ->end();
    }
}

