<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadCountryData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\Country;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadCountryData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Country'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Country());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new Country();
            $fixture
                ->setId($item['country_id'])
                ->setName($item['country']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('country-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/070_country';
    }

    public function getOrder()
    {
        return 70; // the order in which fixtures will be loaded
    }
}

