<?php

namespace Iluni\BookBundle\Library\LD3;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Department Edit Class
 */

class DepartmentEditLD3 extends BaseEditLD3
{
    // Page Edit Part

    public function getJavascriptOptions($name, $entity)
    {
        $master = $entity->getFaculty();
        $detail = $entity->getDepartment();

        $result = array(
            'short_form_name'   => $name,
            'base_path_route'   => 'partial_department_edit_dummy',
            'main_path_route'   => 'partial_department_edit',
            'master_name'   => 'faculty',
            'detail_name'   => 'department',
            'master_index'  => $master? $master->getId(): 0,
            'detail_index'  => $detail? $detail->getId(): 0
        );

        return $result;
    }

    // Ajax Edit Part

    public function getAjaxData($master_index, $detail_index)
    {
        $defaultData['faculty']     = $master_index ?: 0;
        $defaultData['department']  = $detail_index ?: 0;

        return $defaultData;
    }

    public function buildForm(FormFactoryInterface $formFactory, $formName)
    {
        $builder = $formFactory->createNamedBuilder($formName, 'form');
        $builder
            ->add(
                'department',
                'partial_department_choice',
                array('master_index' => $this->master_index)
            );

        return $builder;
    }
}

