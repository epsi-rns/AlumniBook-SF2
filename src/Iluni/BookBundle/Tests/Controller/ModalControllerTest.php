<?php

namespace Iluni\BookBundle\Tests\Controller;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test modal controller.
 * This will not test in iframe box.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ModalControllerTest extends ControllerTestCase
{
    public function testModal()
    {
        $client = $this->startScenario();

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_modalfilter';
        $formData = array(
            $formName.'[name]'  => '%nony%'
        );


        // new alumni entity
        $crawler = $client->request('GET', '/modal/alumni/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Submit it with create action
        $form = $crawler->selectButton('Apply')->form($formData);
        $client->submit($form);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);


        // new org entity
        $crawler = $client->request('GET', '/modal/org/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Submit it with create action
        $form = $crawler->selectButton('Apply')->form($formData);
        $client->submit($form);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);


        // new community entity
        $crawler = $client->request('GET', '/modal/community/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Submit it with create action
        $form = $crawler->selectButton('Apply')->form($formData);
        $client->submit($form);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }
}

