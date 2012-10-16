<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACommunitiesControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        // find entity
        $crawler = $client->request('GET', '/acommunities/');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // reset form
        $link = $crawler->selectLink('Reset')->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_acommunitiesfilter';
        $formData = array(
            $formName.'[orderBy]'  => 81,
            $formName.'[community][faculty]'  => 4
        );

        $this->continueFilterScenario($crawler, $formData, 'list_edit');
    }

    public function testCategoryEach()
    {
        $client = $this->startScenario();
        $idbase = 'iluni_bookbundle_acommunitiesfilter_community_';

        // narrow by program
        $crawler = $client->request('GET', '/acommunities/20/p');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element1 = 'select#'.$idbase.'program';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Master', $node->text());

        // narrow by faculty
        $crawler = $client->request('GET', '/acommunities/4/f');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element1 = 'select#'.$idbase.'faculty';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Engineering', $node->text());

        // narrow by department
        $crawler = $client->request('GET', '/acommunities/402/d');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element1 = 'select#'.$idbase.'faculty';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Engineering', $node->text());

        $element1 = 'select#'.$idbase.'department';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Mechanical Engineering', $node->text());

        // narrow by year
        $crawler = $client->request('GET', '/acommunities/1993/y');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = 'input#'.$idbase.'classYear';
        $node = $crawler->filter($element);
        $this->assertEquals('1993', $node->attr('value'));

        // narrow by decade
        $crawler = $client->request('GET', '/acommunities/1990/de');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element1 = 'select#'.$idbase.'decade';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('199x', $node->text());

        // narrow by community year
        $crawler = $client->request('GET', '/acommunities/1/1993/cy');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }

    public function testCategoryCommunity()
    {
        $client = $this->startScenario();
        $idbase = 'iluni_bookbundle_acommunitiesfilter_community_';

        // narrow by community year
        $crawler = $client->request('GET', '/acommunities/2/c');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element1 = 'select#'.$idbase.'program';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Regular Bachelor', $node->text());

        $element1 = 'select#'.$idbase.'faculty';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Engineering', $node->text());

        $element1 = 'select#'.$idbase.'department';
        $element2 = 'option[selected]';
        $node = $crawler->filter($element1)->filter($element2);
        $this->assertEquals('Mechanical Engineering', $node->text());
    }
}

