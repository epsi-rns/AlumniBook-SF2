<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/community/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_communityfilter';
        $formData = array(
            $formName.'[orderBy]'  => 94,
            $formName.'[faculty]'  => 4
        );

        $url_path = '/community/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/community/table?page=1&orderBy=94';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

