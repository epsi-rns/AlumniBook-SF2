<?php

namespace Iluni\BookBundle\Admin\Category;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

/**
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class JobPositionAdmin extends Admin
{
    /**
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $alias = $query->getRootAlias();
        $query->andWhere($alias.'.id > 1');

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('label'=>'Rank'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertMinLength(array('limit' => 5))
            ->assertMaxLength(array('limit' => 50))
            ->end();
    }
}

