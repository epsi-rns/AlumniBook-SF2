<?php

namespace Iluni\BookBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * ControllerTestCase
 *
 * This is a base class for controller test
 * containing common scenario.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
abstract class ControllerTestCase extends WebTestCase
{
    private $httpHeaders = array('HTTP_HOST' => 'book2');

    protected $client;

    protected function startScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), $this->httpHeaders);
        $this->client = $client;

        // login
        $crawler = $client->request('GET', '/user/login');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $formData = array(
            '_username'  => 'editor',
            '_password'  => 'editor'
        );

        $form = $crawler->selectButton('login')->form($formData);
        $client->submit($form);

        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(302, $statusCode);

        // set with right language
        $crawler = $client->request('GET', '/en/language.json');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        return $client;
    }

    public function continueCategoriesScenario($url_path)
    {
        $client = $this->client;

        // find categories
        $crawler = $client->request('GET', $url_path);
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
    }

    public function continueFilterScenario($url_path, $formData)
    {
        $client = $this->client;

        $crawler = $client->request('GET', $url_path);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        // Submit it with create action
        $form = $crawler->selectButton('Apply')->form($formData);
        $client->submit($form);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }

    public function continueTableScenario($url_path, $linkelement)
    {
        $client = $this->client;

        $crawler = $client->request('GET', $url_path);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);

        $element = '[name="'.$linkelement.'"]';
        $link = $crawler->filter($element)->first()->link();
        $crawler = $client->click($link);
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertSame(200, $statusCode);
    }

    public function continueCrudScenario($crawler, $formData, $testValue)
    {
        $client = $this->client;

        // Create a new entry in the database
        $link = $crawler->selectLink('Create a new entry')->link();
        $crawler = $client->click($link);

        // Submit it with create action
        $form = $crawler->selectButton('Create')->form($formData);
        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains
        // an attribute with value equals $testValue
        $element = '[value="'.$testValue.'"]';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() > 0);

        // Submit it with update action
        $form = $crawler->selectButton('Save')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains the flash bag
        $element = 'div.flash_info:contains("Saved successfully")';
        $node = $crawler->filter($element);
        $this->assertTrue($node->count() == 1);

        // Delete the entity
        $form = $crawler->selectButton('Delete')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $content = $client->getResponse()->getContent();
        $this->assertNotRegExp('/'.$testValue.'/', $content);
    }
}

