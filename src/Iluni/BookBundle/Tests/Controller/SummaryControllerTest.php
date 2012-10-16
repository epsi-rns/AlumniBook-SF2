<?php

namespace Iluni\BookBundle\Tests\Controller;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario that test each action in summary controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class SummaryControllerTest extends ControllerTestCase
{
    public function testModal()
    {
        $client = $this->startScenario();
        $formName = 'iluni_bookbundle_summaryfilter';

        // find entity
        $crawler = $client->request('GET', '/summary/total');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        foreach (array(1,2,3,4,5) as $value) {
            // Prepare Data, fill in the form
            $formData = array($formName.'[groupBy]'  => $value);

            // Submit it with create action
            $form = $crawler->selectButton('Apply')->form($formData);
            $client->submit($form);
            $statusCode = $client->getResponse()->getStatusCode();
            $this->assertSame(200, $statusCode);
        }
    }
}

