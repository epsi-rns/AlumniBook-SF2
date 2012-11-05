<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AExperiencesControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/aexperiences/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_aexperiencesfilter';
        $formData = array(
            $formName.'[orderBy]'  => 44,
            $formName.'[community][faculty]'  => 4
        );

        $url_path = '/aexperiences/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/aexperiences/table?page=1&orderBy=105';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

