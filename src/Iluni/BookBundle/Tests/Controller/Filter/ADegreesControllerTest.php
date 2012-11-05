<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ADegreesControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/adegrees/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_adegreesfilter';
        $formData = array(
            $formName.'[orderBy]'  => 101,
            $formName.'[community][faculty]'  => 4
        );

        $url_path = '/adegrees/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/adegrees/table?page=1&orderBy=105';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

