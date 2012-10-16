<?php

namespace Iluni\BookBundle\Tests\Controller;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Scenario that test ajax on partial controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class PartialControllerTest extends ControllerTestCase
{
    public function testDepartmentFilter()
    {
        $client = $this->startScenario();

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/partial/department/filter/name/alumni/id/4/val/402',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'option[value="402"]';
        $text = $crawler->filter($element)->text();
        $this->assertEquals('Mechanical Engineering', $text);
    }

    public function testDepartmentEdit()
    {
        $client = $this->startScenario();

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/partial/department/edit/name/alumni/id/4/val/402',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'option[value="402"]';
        $text = $crawler->filter($element)->text();
        $this->assertEquals('Mechanical Engineering', $text);
    }

    public function testDistrictEdit()
    {
        $client = $this->startScenario();

        // find alumni entity detail
        $crawler = $client->request(
            'GET',
            '/partial/district/edit/name/address/id/16/val/248',
            array(),
            array(),
            array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest')
        );
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'option[value="248"]';
        $text = $crawler->filter($element)->text();
        $this->assertEquals('Kota Yogyakarta', $text);
    }
}

