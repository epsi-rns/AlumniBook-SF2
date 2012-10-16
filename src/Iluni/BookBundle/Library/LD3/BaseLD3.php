<?php

/**
 * @package    ilunibook
 * @subpackage ld3
 * @author     E.R. Nurwijayadi
 * @version    1.0
 *
 * Linked Dynamic Drop Down Class Library
 * Extending Controller
 * Using Master Table Relationship
 *
 * Contain two parts for each controller:
 * - Partial on Page (Original)
 * - Partial on Ajax (Replaced)
 *
 * Note: Using compositing to emulate trait
 *
 */

namespace Iluni\BookBundle\Library\LD3;

abstract class BaseLD3
{
    private $controller;

    protected $name;
    protected $master_index;

    /* Comment: Output
    $JavascriptOptions = array(
        'short_form_name'   => null,
        'base_path_route'   => null,
        'main_path_route'   => null,
        'master_name'   => null,
        'detail_name'   => null,
        'master_index'  => 0,
        'detail_index'  => 0
    );
    * */

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    protected function getController()
    {
        return $this->controller;
    }

    // Page Parts

    // public abstract function initPageOptions(...); method overloading

    // Ajax Parts

    abstract public function render($resource_name);

    abstract public function initAjaxOptions($name, $master_index, $detail_index);

    abstract protected function getForm();
}

