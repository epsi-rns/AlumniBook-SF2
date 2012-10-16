<?php

namespace Iluni\BookBundle\Library\LD3;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Helper\IluniBookHelper;

/**
 * Base Edit Abstract Class
 */


abstract class BaseEditLD3 extends BaseLD3 implements ConfigurableEditLD3Interface
{
    // Page Edit Part

    // Ajax Edit Part

    public function render($resource_name)
    {
        // validation, check form name availability
        if (!$this->name) {
            return new Response();
        }

        $c = $this->getController();
        $form = $this->getForm();
        $form->bind($this->ajaxData);

        return $c->render($resource_name, array('form' => $form->createView()));
    }

    public function initAjaxOptions($name, $master_index, $detail_index)
    {
        $this->name = $name;
        $this->master_index = $master_index;
        $this->ajaxData = $this->getAjaxData($master_index, $detail_index);
    }

    protected function getForm()
    {
        $c = $this->getController();
        $formFactory = $c->get('form.factory');
        $formName = IluniBookHelper::getNamespace('type', $this->name);

        // process form
        $builder = $this->buildForm($formFactory, $formName);
        $form = $builder->getForm();

        return $form;
    }
}

