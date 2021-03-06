<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/org/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_organizationfilter';
        $formData = array(
            $formName.'[orderBy]'  => 12,
            $formName.'[name]'  => '%epa%',
        );


        $url_path = '/org/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/org/table?page=1&orderBy=25';
        $this->continueTableScenario($url_path, 'list_show');
    }
}

