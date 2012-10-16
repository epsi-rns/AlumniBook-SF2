<?php

namespace Iluni\BookBundle\Tests\Controller;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Miscellanous scenario that test about controller.
 * This will test both alumni and organization.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AboutControllerTest extends ControllerTestCase
{
    public function testAlumni()
    {
        $client = $this->startScenario();

        // find reference entity
        $client->request('GET', '/alumni/first.json');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // get reference key
        $json = $client->getResponse()->getContent();
        $bags = json_decode($json);
        $aid  = $bags->id;

        // find alumni entity
        $crawler = $client->request('GET', '/about/'.$aid.'/alumni/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'tbody#AlumnaID';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() > 0);

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/about/'.$aid.'/adet/',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/about/'.$aid.'/odeta/',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }

    public function testOrg()
    {
        $client = $this->startScenario();

        // find reference entity
        $client->request('GET', '/org/first.json');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // get reference key
        $json = $client->getResponse()->getContent();
        $bags = json_decode($json);
        $oid  = $bags->id;

        // find alumni entity
        $crawler = $client->request('GET', '/about/'.$oid.'/org/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'tbody#OrganizationID';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() > 0);

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/about/'.$oid.'/odet/',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/about/'.$oid.'/adeto/',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }
}

