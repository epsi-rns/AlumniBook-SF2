<?php

namespace Iluni\BookBundle\Library\LD3;

use Symfony\Component\Form\FormFactoryInterface;

interface ConfigurableEditLD3Interface
{
    // Page Configurable Parts

    public function getJavascriptOptions($name, $entity);

    // Ajax Configurable Parts

    public function getAjaxData($master_index, $detail_index);

    public function buildForm(FormFactoryInterface $formFactory, $formName);
}

