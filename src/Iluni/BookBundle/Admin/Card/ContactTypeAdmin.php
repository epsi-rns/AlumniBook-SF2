<?php

namespace Iluni\BookBundle\Admin\Card;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ContactTypeAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array(
                'label'=>'Type',
                'help'=>'Contact Type'
            ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertMinLength(array('limit' => 3))
            ->assertMaxLength(array('limit' => 25))
            ->end();
    }
}

