<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class BirthdayControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/alumni/birthday/11');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_birthdayfilter';
        $formData = array(
            $formName.'[orderBy]'  => 75
        );

        $url_path = '/alumni/birthday/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/alumni/birthday/table?page=1&orderBy=75';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

