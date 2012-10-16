<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommunityControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/community/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $testValue = 'nameFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_communitytype';
        $formData = array(
            $formName.'[name]'  => $testValue,
            $formName.'[faculty]'  => rand(1, 8),
            $formName.'[program]'  => 10,
            $formName.'[typeId]'  => 1,

            // note: override by ajax, no value is allowed
            // $formName.'[department]'  => rand(401, 408),
        );
        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

