<?php

namespace Iluni\BookBundle\Controller\Parts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use Citra\CommonBundle\Library\Controller\InitializableControllerInterface;
use Iluni\BookBundle\Library\LD3\DepartmentFilterLD3;
use Iluni\BookBundle\Library\LD3\DepartmentEditLD3;
use Iluni\BookBundle\Library\LD3\DistrictEditLD3;

/**
 * DynamicDropdown controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class DynamicDropdownController extends Controller implements
    InitializableControllerInterface
{
    private $allowDebugAjax = false;

    public function initialize(Request $request)
    {
        $route  = $request->attributes->get('_route');
        $isAjax = $request->isXmlHttpRequest();

        if (!$isAjax and !$this->allowDebugAjax) {
            $message = 'You are not assigned. Nice Try!';
            throw new NotFoundHttpException($message);
        }
    }

    // Format: /department/filter/name/{name}/id/{master_index}/val/{detail_index}
    public function departmentFilterAction($name, $master_index, $detail_index)
    {
        $ld3 = new DepartmentFilterLD3($this);
        $ld3->initAjaxOptions($name, $master_index, $detail_index);
        $resource = 'IluniBookBundle:Shared/Partial:department.filter.html.twig';

        return $ld3->render($resource);
    }

    // Format: /department/edit/name/{name}/id/{master_index}/val/{detail_index}
    public function departmentEditAction($name, $master_index, $detail_index)
    {
        $ld3 = new DepartmentEditLD3($this);
        $ld3->initAjaxOptions($name, $master_index, $detail_index);
        $resource = 'IluniBookBundle:Shared/Partial:department.edit.html.twig';

        return $ld3->render($resource);
    }

    // Format: /district/edit/name/{name}/id/{master_index}/val/{detail_index}
    public function districtEditAction($name, $master_index, $detail_index)
    {
        $ld3 = new DistrictEditLD3($this);
        $ld3->initAjaxOptions($name, $master_index, $detail_index);
        $resource = 'IluniBookBundle:Shared/Partial:district.edit.html.twig';

        return $ld3->render($resource);
    }
}

