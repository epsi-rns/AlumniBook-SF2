<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadAOMapData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Detail\AlumniOrgMap;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniOrgMapData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['AOMap'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new AlumniOrgMap();

            if (array_key_exists('aid', $item)) {
                $alumni = $this->getReference('alumni-'.$item['aid']);
                $fixture->setAlumni($em->merge($alumni));
            }

            if (array_key_exists('oid', $item)) {
                $org = $this->getReference('org-'.$item['oid']);
                $fixture->setOrganization($em->merge($org));
            }

            if (array_key_exists('job_type_id', $item)) {
                $JobType = $this->getReference('job_type-'.$item['job_type_id']);
                $fixture->setJobType($em->merge($JobType));
            }

            if (array_key_exists('job_position_id', $item)) {
                $JobPosition = $this->getReference('job_position-'.$item['job_position_id']);
                $fixture->setJobPosition($em->merge($JobPosition));
            }

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('ao_map-'.$item['mid'], $fixture);
        }

        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $alumni = $this->getReference('alumni-anon-'.$i);
            $org = $this->getReference('org-fake-'.$i);
            $JobType = $this->getReference('job_type-'.(($i % 10) + 1));
            $JobPosition = $this->getReference('job_position-'.(($i % 9) + 1));

            $fixture = new AlumniOrgMap();
            $fixture
                ->setAlumni($em->merge($alumni))
                ->setOrganization($em->merge($org))
                ->setJobType($em->merge($JobType))
                ->setJobPosition($em->merge($JobPosition))
                ->setDescription('Mapping number '.$i);

            $em->persist($fixture);
            $this->addReference('ao_map-'. $i, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Detail/210_ao_map';
    }

    public function getOrder()
    {
        return 210; // the order in which fixtures will be loaded
    }
}

