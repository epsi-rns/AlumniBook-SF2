<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class MContactsControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find master entity
        $crawler = $client->request('GET', '/amap/first');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find detail entity
        $link = $crawler->selectLink('Contacts')->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $testValue = 'contactFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_contacttype';
        $formData = array(
            $formName.'[contactType]'  => rand(1, 5),
            $formName.'[contact]'  => $testValue
        );

        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

