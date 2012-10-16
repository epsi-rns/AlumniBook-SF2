<?php

namespace Iluni\BookBundle\Library\LD3;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Department Filter Class
 */

class DepartmentFilterLD3 extends BaseFilterLD3
{
    // Page Filter Part

    public function getJavascriptOptions($name, $params)
    {
        $master_index = 0;
        $detail_index = 0;

        if (isset($params['community'])) {
            $cm = $params['community'];
            $master_index = empty($cm['faculty'])? 0: $cm['faculty'];
            $detail_index = empty($cm['department'])? 0: $cm['department'];
        }

        $result = array(
            'short_form_name'   => $name,
            'base_path_route'   => 'partial_department_filter_dummy',
            'main_path_route'   => 'partial_department_filter',
            'master_name'   => 'faculty',
            'detail_name'   => 'department',
            'master_index'  => $master_index,
            'detail_index'  => $detail_index
        );

        return $result;
    }

    // Ajax Edit Part

    public function getAjaxData($master_index, $detail_index)
    {
        $community['faculty']       = $master_index? $master_index : 0;
        $community['department']    = $detail_index? $detail_index : 0;
        $defaultData['community']   = $community;

        return $defaultData;
    }

    public function buildForm(FormFactoryInterface $formFactory, $formName)
    {
        $subBuilder = $formFactory
            ->createNamedBuilder('community', 'form')
            ->add(
                'department',
                'partial_department_choice',
                array('master_index' => $this->master_index)
            );

        $builder = $formFactory
            ->createNamedBuilder($formName, 'form')
            ->add($subBuilder);

        return $builder;
    }
}

