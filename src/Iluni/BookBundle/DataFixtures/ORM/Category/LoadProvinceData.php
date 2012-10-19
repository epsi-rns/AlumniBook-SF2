<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadProvinceData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Category\Province;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadProvinceData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Province'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Province());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new Province();
            $fixture
                ->setId($item['province_id'])
                ->setName($item['province']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('province-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '071_province';
    }

    public function getOrder()
    {
        return 71; // the order in which fixtures will be loaded
    }
}

