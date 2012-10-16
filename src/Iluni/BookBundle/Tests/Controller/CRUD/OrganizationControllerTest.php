<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OrganizationControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/org/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $testValue = 'nameFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_organizationtype';
        $formData = array(
            $formName.'[name]'  => $testValue
        );

        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

