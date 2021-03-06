<?php

namespace Citra\CommonBundle\Library\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
* @author Matt Drollette <matt@drollette.com>
*/
interface InitializableControllerInterface
{
    public function initialize(Request $request);
}

