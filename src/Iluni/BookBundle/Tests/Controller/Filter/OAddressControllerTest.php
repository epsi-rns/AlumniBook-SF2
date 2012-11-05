<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OAddressControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/office/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_oaddressfilter';
        $formData = array(
            $formName.'[orderBy]'  => 61
        );

        $url_path = '/office/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/office/table?page=1&orderBy=6';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

