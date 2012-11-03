<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadDistrictData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\District;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadDistrictData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['District'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new District());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new District();
            $province = $this->getReference('province-'.$item['province_id']);

            $fixture
                ->setProvince($em->merge($province))
                ->setId($item['district_id'])
                ->setName($item['district']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('district-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/072_district';
    }

    public function getOrder()
    {
        return 72; // the order in which fixtures will be loaded
    }
}

