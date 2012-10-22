<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadJobPositionData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Category\JobPosition;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadJobPositionData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['JobPosition'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new JobPosition());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new JobPosition();
            $fixture
                ->setId($item['job_position_id'])
                ->setName($item_en['job_position']);
            $repository->translate($fixture, 'name', 'id', $item_id['job_position']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('job_position-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '041_job_position';
    }

    public function getOrder()
    {
        return 41; // the order in which fixtures will be loaded
    }
}

