<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OFieldsControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        $url_path = '/ofields/categories';
        $this->continueCategoriesScenario($url_path);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_ofieldsfilter';
        $formData = array(
            $formName.'[orderBy]'  => 46
        );

        $url_path = '/ofields/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/ofields/table?page=1&orderBy=23';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

