<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadFacultyData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Category\Faculty;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadFacultyData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Faculty'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Faculty());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new Faculty();
            $fixture
                ->setId($item['faculty_id'])
                ->setName($item_en['faculty']);
            $repository->translate($fixture, 'name', 'id', $item_id['faculty']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('faculty-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '021_faculty';
    }

    public function getOrder()
    {
        return 21; // the order in which fixtures will be loaded
    }
}

