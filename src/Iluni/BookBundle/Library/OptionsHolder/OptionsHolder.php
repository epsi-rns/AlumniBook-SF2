<?php

namespace Iluni\BookBundle\Library\OptionsHolder;

class OptionsHolder
{
    private $options = array(); // result

    public function get()
    {
        return $this->options;
    }

    public function set(array $options = array())
    {
        $this->options = $this->mergeArrays($this->options, $options);

        return $this;   // fluent interface
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
}

