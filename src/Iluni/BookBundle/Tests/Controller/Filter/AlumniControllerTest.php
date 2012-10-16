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

        $this->continueFilterScenario($crawler, $formData, 'list_show');
    }

    public function testBirthFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/alumni/birth');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_alumnifilter';
        $formData = array(
            $formName.'[orderBy]'  => 1
        );

        $this->continueFilterScenario($crawler, $formData, 'list_edit');
    }
}

