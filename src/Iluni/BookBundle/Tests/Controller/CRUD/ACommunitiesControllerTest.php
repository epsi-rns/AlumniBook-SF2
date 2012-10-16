<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACommunitiesControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find master entity
        $crawler = $client->request('GET', '/alumni/first');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find detail entity
        $link = $crawler->selectLink('Communities')->link();
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
        $cid  = $bags->id;

        // Prepare Data, fill in the form
        $testValue = 'testFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_acommunitiestype';
        $formData = array(
            $formName.'[community][id]'  => $cid,
            $formName.'[classYear]'  => rand(1970, 1990),
            $formName.'[classSub]'  => $testValue
        );
        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

