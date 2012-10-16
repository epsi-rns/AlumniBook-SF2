<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ADegreesControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find master entity
        $crawler = $client->request('GET', '/alumni/first');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find detail entity
        $link = $crawler->selectLink('Degrees')->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $testValue = 'instFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_adegreestype';
        $formData = array(
            $formName.'[strata]'  => 10,
            $formName.'[institution]'  => $testValue,
            $formName.'[admitted]'  => rand(1970, 1990),
        );

        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

