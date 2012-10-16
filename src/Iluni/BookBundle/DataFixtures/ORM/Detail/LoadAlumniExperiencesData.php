<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadAExperiencesData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookDetailData;
use Iluni\BookBundle\Entity\Detail\AlumniExperiences;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniExperiencesData extends LoadBookDetailData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['AExperiences'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new AlumniExperiences();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setOrganization($item['organization']);

            if (array_key_exists('description', $item)) {
                $fixture->setDescription($item['description']);
            }

            if (array_key_exists('job_position', $item)) {
                $fixture->setJobPosition($item['job_position']);
            }

            if (array_key_exists('year_in', $item)) {
                $fixture->setYearIn($item['year_in']);
            }

            if (array_key_exists('year_out', $item)) {
                $fixture->setYearOut($item['year_out']);
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniExperiences();

            $ref_aid    = $this->getReference('alumni-anon-'.$i);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setOrganization('PT. '.$i)
                ->setDescription('Pekerjaan '.$i);

            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '122_aexperiences';
    }

    public function getOrder()
    {
        return 122; // the order in which fixtures will be loaded
    }
}

