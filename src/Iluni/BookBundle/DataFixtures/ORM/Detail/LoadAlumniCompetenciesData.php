<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadACompetenciesData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookDetailData;
use Iluni\BookBundle\Entity\Detail\AlumniCompetencies;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniCompetenciesData extends LoadBookDetailData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['ACompetencies'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new AlumniCompetencies();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);
            $ref_xid    = $this->getReference('competency-'.$item['competency_id']);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setCompetency($em->merge($ref_xid));

            if (array_key_exists('description', $item)) {
                $fixture->setDescription($item['description']);
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniCompetencies();

            $ref_aid    = $this->getReference('alumni-anon-'.$i);
            $ref_xid    = $this->getReference('competency-'.(($i % 8) + 1));

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setCompetency($em->merge($ref_xid))
                ->setDescription('Compete-'.$i);


            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '120_acompetencies';
    }

    public function getOrder()
    {
        return 120; // the order in which fixtures will be loaded
    }
}

