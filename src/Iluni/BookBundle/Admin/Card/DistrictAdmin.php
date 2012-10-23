<?php

namespace Iluni\BookBundle\Admin\Card;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

/**
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class DistrictAdmin extends Admin
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
            ->add('name', null, array('help'=>'District/ City'))
            ->add('province', null, array(
                'help'=>'Select province where the district belong to'
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('province');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('province');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('name')
            ->assertMinLength(array('limit' => 3))
            ->assertMaxLength(array('limit' => 30))
            ->end();
    }
}

