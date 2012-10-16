<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AMapControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find master entity
        $crawler = $client->request('GET', '/alumni/first');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find detail entity
        $link = $crawler->selectLink('Map')->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find reference entity
        $client->request('GET', '/org/first.json');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // get reference key
        $json = $client->getResponse()->getContent();
        $bags = json_decode($json);
        $oid  = $bags->id;

        // Prepare Data, fill in the form
        $testValue = 'descFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_amaptype';
        $formData = array(
            $formName.'[description]'  => $testValue,
            $formName.'[organization][id]'  => $oid,
            $formName.'[jobType]'  => rand(1, 10),
            $formName.'[jobPosition]'  => rand(1, 9),
        );

        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

