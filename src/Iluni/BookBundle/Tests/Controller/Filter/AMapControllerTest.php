<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AMapControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        $url_path = '/amap/categories';
        $this->continueCategoriesScenario($url_path);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_amapfilter';
        $formData = array(
            $formName.'[orderBy]'  => 101,
            $formName.'[community][faculty]'  => 4
        );

        $url_path = '/amap/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/amap/table?page=1&orderBy=4';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

