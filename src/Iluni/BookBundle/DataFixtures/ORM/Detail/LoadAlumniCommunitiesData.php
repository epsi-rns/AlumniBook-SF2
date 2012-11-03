<?php
// src/Iluni\BookBundle/DataFixtures/ORM/Detail/LoadACommunitiesData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Detail\AlumniCommunities;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniCommunitiesData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['ACommunities'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new AlumniCommunities();

            $alumni = $this->getReference('alumni-'.$item['aid']);
            $community  = $this->getReference('community-'.$item['cid']);

            $fixture
                ->setAlumni($em->merge($alumni))
                ->setCommunity($em->merge($community));

            if (array_key_exists('class_year', $item)) {
                $fixture->setClassYear($item['class_year']);
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniCommunities();

            $alumni = $this->getReference('alumni-anon-'.$i);
            $community  = $this->getReference('community-'.(($i % 8) + 1));

            $fixture
                ->setAlumni($em->merge($alumni))
                ->setCommunity($em->merge($community))
                ->setClassYear(1875+(round($i/5)*5));


            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Detail/110_acommunities';
    }

    public function getOrder()
    {
        return 110; // the order in which fixtures will be loaded
    }
}

