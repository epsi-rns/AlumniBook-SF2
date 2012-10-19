<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadDepartmentData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Category\Department;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadDepartmentData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Department'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Department());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new Department();
            $faculty = $this->getReference('faculty-'.$item['faculty_id']);

            $fixture
                ->setFaculty($em->merge($faculty))
                ->setId($item['department_id'])
                ->setName($item_en['department']);
            $repository->translate($fixture, 'name', 'id', $item_id['department']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('department-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '022_department';
    }

    public function getOrder()
    {
        return 22; // the order in which fixtures will be loaded
    }
}

