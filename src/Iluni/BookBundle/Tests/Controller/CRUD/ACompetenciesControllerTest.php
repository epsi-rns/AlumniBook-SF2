<?php

namespace Iluni\BookBundle\Tests\Controller\CRUD;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Complete scenario test for CRUD controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACompetenciesControllerTest extends ControllerTestCase
{
    public function testCrudScenario()
    {
        $client = $this->startScenario();

        // find master entity
        $crawler = $client->request('GET', '/alumni/first');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find detail entity
        $link = $crawler->selectLink('Competencies')->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $testValue = 'descFoo'.rand(5, 15);
        $formName = 'iluni_bookbundle_acompetenciestype';
        $formData = array(
            $formName.'[competency]'  => rand(1, 8),
            $formName.'[description]'  => $testValue
        );

        $this->continueCrudScenario($crawler, $formData, $testValue);
    }
}

