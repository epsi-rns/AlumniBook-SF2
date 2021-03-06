<?php

namespace Iluni\BookBundle\Admin\Campus;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

/**
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class FacultyAdmin extends Admin
{
    /**
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $alias = $query->getRootAlias();
        $query->andWhere($alias.'.id > 0');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('help'=>'A faculty name'))
            ->add('departments', 'sonata_type_collection', array(), array(
                'edit' => 'inline',  // inline|standard
                'inline' => 'table', // table|standard
                'sortable'  => 'position'
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
            ->assertMaxLength(array('limit' => 35))
            ->end();
    }
}

