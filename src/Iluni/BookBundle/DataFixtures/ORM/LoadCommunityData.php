<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadCommunityData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookCategoryData;
use Iluni\BookBundle\Entity\Community;

/**
 * Load data fixtures for an entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadCommunityData extends LoadBookCategoryData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Community'];

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new Community();

            $faculty    = $this->getReference('faculty-'.$item['faculty_id']);
            $department = $this->getReference('department-'.$item['department_id']);
            $program    = $this->getReference('program-'.$item['program_id']);

            $fixture
                ->setId($item['cid'])
                ->setName($item['name'])
                ->setTypeId($item['type_id'])
                // relationship
                ->setFaculty($em->merge($faculty))
                ->setDepartment($em->merge($department))
                ->setProgram($em->merge($program));

            if (array_key_exists('brief', $item)) {
                $fixture->setBrief($item['brief']);
            }

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('community-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '025_community';
    }

    public function getOrder()
    {
        return 25; // the order in which fixtures will be loaded
    }
}

