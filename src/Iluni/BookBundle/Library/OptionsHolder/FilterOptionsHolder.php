<?php

namespace Iluni\BookBundle\Library\OptionsHolder;

//use Symfony\Component\OptionsResolver\OptionsResolver,
//use Symfony\Component\OptionsResolver\OptionsResolverInterface,
//use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Helper\IluniBookHelper;

class FilterOptionsHolder
{
    private $resolver;

    private $request;
    private $session;

    private $name;
    private $filter_namespace;
    private $session_namespace;

    // array_merge_recursive problem
    // nested otions will be tackled in SF 2.2
    // https://github.com/symfony/symfony/issues/4833
    private $params_default = array();
    private $params_request = array();
    private $params_session = array();
    private $params_replace = array();  // result

    //  Other cool 7 characters names
    //  $params_initial
    //  $params_trigger
    //  $params_options

    public function __construct($session)
    {
        $this->session = $session;

        //  $this->resolver = new OptionsResolver();
        //  $this->setDefaultOptions();
    }

    protected function setDefaultOptions()
    {
        $this->resolver->setDefaults(array('OrderBy' => null));
    }

    public function get()
    {
        // due to 4833 issue
        // return $this->resolver->resolve();
        return $this->params_replace;
    }

    public function init($module_name, Request $request)
    {
        $this->name = $module_name;
        $this->filter_namespace     = IluniBookHelper::getNamespace('filter', $module_name);
        $this->session_namespace    = IluniBookHelper::getNamespace('session', $module_name);

        // get request manually by parameters,
        // because request from service doesn't handle POST emulation
        $this->request = $request;

        return $this;   // fluent interface
    }


    public function set(array $options = array())
    {
        //  $this->resolver->setDefaults($options);

        // due to 4833 issue
        $this->params_replace = $this->mergeArrays(
            $this->params_replace,
            $options
        );
        $this->params_default = $this->params_replace;

        return $this;   // fluent interface
    }

    public function fromRequest()
    {
        $postRequest = $this->request->request;
        $params_request = (array) $postRequest->get($this->filter_namespace);
        $params_request = array_filter($params_request);

        $this->params_request = $params_request;
        //  $this->resolver->setDefaults($params_request);

        // due to 4833 issue
        $this->params_replace = $this->mergeArrays(
            $this->params_replace,
            $this->params_request
        );
    }

    public function fromSession()
    {
        $session = $this->session;
        $params_session = (array) $session->get($this->session_namespace);
        $params_session = array_filter($params_session);

        $this->params_session = $params_session;
        //  $this->resolver->setDefaults($params_session);

        // due to 4833 issue
        $this->params_replace = $this->mergeArrays(
            $this->params_replace,
            $this->params_session
        );
    }

    public function toSession()
    {
        $session = $this->session;
        //  $params_replace = $this->resolver->resolve();

        // due to 4833 issue
        $params_replace = $this->params_replace;

        $session->set($this->session_namespace, $params_replace);
    }

    public function resetSession()
    {
        $session = $this->session;
        $params_replace = $this->params_default;
        $session->set($this->session_namespace, $params_replace);

        //  $this->resolver = new OptionsResolver();
        //  $this->setDefaultOptions();
        //  $this->resolver->setDefaults($params_replace);

        // due to 4833 issue
        $this->params_replace = $params_replace;
    }

    public function compileOptions()
    {
        $request = $this->request;

        if ('POST' == $request->getMethod()) {
            $this->fromRequest();
            $this->toSession(); // store current options in the session
        } else {
            $query = $request->query->all();

            if (isset($query['_reset'])) {
                $this->resetSession();
            } else {
                $this->fromSession();
            }
        }

        return $this->get();
    }



    // emulate POST, to alter request form, must be called before bind
    public function ifKeepSessionMergeParams($params_request)
    {
        $this->set($params_request);

        $request = $this->request;
        $query = $request->query->all();

        if (isset($query['_keepsession'])) {
            $this->fromSession();
        }

        return $this->get();
    }

    // Recursively overwrite distincttive
    private function mergeArrays($arr1, $arr2)
    {
        foreach ($arr2 as $key => $value) {
            if (array_key_exists($key, $arr1) and is_array($value)) {
                $arr1[$key] = $this->mergeArrays($arr1[$key], $arr2[$key]);
            } else {
                $arr1[$key] = $value;
            }
        }

        return $arr1;
    }

    private function arrayFlatten($params_iterate)
    {
        // Flatten all parameters, example: $params['community']
        $params_flatten = array();

        $RAI = new \RecursiveArrayIterator($params_iterate);
        $RII = new \RecursiveIteratorIterator($RAI);

        foreach ($RII as $key => $value) {
            $params_flatten[$key] = $value;
        }

        return $params_flatten;
    }
}

