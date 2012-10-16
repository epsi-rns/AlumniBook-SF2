<?php

namespace Iluni\BookBundle\Tests\Controller;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Miscellanous test scenario on default controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class DefaultControllerTest extends ControllerTestCase
{
    public function testDefault()
    {
        $client = $this->startScenario();

        $crawler = $client->request('GET', '/');
        $element = 'html:contains("AlumniBook")';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() > 0);

        $crawler = $client->request('GET', '/menu');
        $element = 'div.moduletable_menu';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() > 1);

        $crawler = $client->request('GET', '/index.atom');
        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertContains('rss+xml', $contentType);
    }
}

