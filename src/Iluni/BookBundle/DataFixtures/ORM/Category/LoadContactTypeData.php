<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadContactTypeData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\ContactType;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadContactTypeData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['ContactType'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new ContactType());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new ContactType();
            $fixture
                ->setId($item['ct_id'])
                ->setName($item_en['contact_type']);
            $repository->translate($fixture, 'name', 'id', $item_id['contact_type']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('contact_type-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/060_contact_type';
    }

    public function getOrder()
    {
        return 60; // the order in which fixtures will be loaded
    }
}

