<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadADegreesData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookDetailData;
use Iluni\BookBundle\Entity\Detail\AlumniDegrees;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniDegreesData extends LoadBookDetailData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['ADegrees'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new AlumniDegrees();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);
            $ref_xid    = $this->getReference('strata-'.$item['strata_id']);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setStrata($em->merge($ref_xid));

            $columns = array('admitted', 'graduated', 'degree',
                'institution', 'major', 'minor', 'concentration');
            foreach ($columns as $column) {
                if (array_key_exists($column, $item)) {
                    $method = 'set'.ucfirst($column);
                    $fixture->$method($item[$column]);
                }
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        $ref_xid    = $this->getReference('strata-10');

        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniDegrees();

            $ref_aid    = $this->getReference('alumni-anon-'.$i);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setStrata($em->merge($ref_xid))
                ->setAdmitted(1875+(round($i/5)*5))
                ->setGraduated(1881+(round($i/5)*5))
                ->setDegree('ST')
                ->setInstitution('University of Indonesia')
                ->setMajor('Faculty-'.$i)
                ->setMinor('Department-'.$i);

            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '123_adegrees';
    }

    public function getOrder()
    {
        return 123; // the order in which fixtures will be loaded
    }
}

