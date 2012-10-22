<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadACertificationsData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookDetailData;
use Iluni\BookBundle\Entity\Detail\AlumniCertifications;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniCertificationsData extends LoadBookDetailData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['ACertifications'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new AlumniCertifications();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setCertification($item['certification']);

            if (array_key_exists('institution', $item)) {
                $fixture->setInstitution($item['institution']);
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniCertifications();

            $ref_aid    = $this->getReference('alumni-anon-'.$i);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setCertification('Ahli-'.$i)
                ->setInstitution('Lembaga-Kursus-'.$i);

            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '121_acertifications';
    }

    public function getOrder()
    {
        return 121; // the order in which fixtures will be loaded
    }
}

