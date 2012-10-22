<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadJobTypeData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Category\JobType;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadJobTypeData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['JobType'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new JobType());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new JobType();
            $fixture
                ->setId($item['job_type_id'])
                ->setName($item_en['job_type']);
            $repository->translate($fixture, 'name', 'id', $item_id['job_type']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('job_type-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '040_job_type';
    }

    public function getOrder()
    {
        return 40; // the order in which fixtures will be loaded
    }
}

