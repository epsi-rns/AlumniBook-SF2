<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class OFieldsControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find categories
        $crawler = $client->request('GET', '/ofields/categories');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // pick test target
        $element = 'ul#categories li a';
        $node = $crawler->filter($element)->first();
        $testValue = $node->text();

        // select category
        $link = $crawler->selectLink($testValue)->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // test selected value
        $element1 = 'select#iluni_bookbundle_ofieldsfilter_bizField';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals($testValue, $node->text());

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_ofieldsfilter';
        $formData = array(
            $formName.'[orderBy]'  => 46
        );

        $this->continueFilterScenario($crawler, $formData, 'list_edit');
    }
}

