<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadStrataData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\Strata;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadStrataData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Strata'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Strata());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new Strata();
            $fixture
                ->setId($item['strata_id'])
                ->setName($item['strata']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('strata-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/031_strata';
    }

    public function getOrder()
    {
        return 31; // the order in which fixtures will be loaded
    }
}

