<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AlumniControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/alumni/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_alumnifilter';
        $formData = array(
            $formName.'[orderBy]'  => 12,
            $formName.'[community][faculty]'  => 4,
            $formName.'[name]'  => '%nymous%',
        );

        $url_path = '/alumni/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/alumni/table?page=1&orderBy=1';
        $this->continueTableScenario($url_path, 'list_show');
    }
}

