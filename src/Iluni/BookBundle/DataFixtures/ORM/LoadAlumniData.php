<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadAlumniData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookData;
use Iluni\BookBundle\Entity\Alumni;

/**
 * Load data fixtures for an entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAlumniData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Alumni'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        $columns = array('name', 'prefix', 'suffix', 'note', 'gender', 'birthplace');

        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new Alumni();

            foreach ($columns as $column) {
                if (array_key_exists($column, $item)) {
                    $method = 'set'.ucfirst($column);
                    $fixture->$method($item[$column]);
                }
            }

            if (array_key_exists('birthdate', $item)) {
                $fixture->setBirthdate(new \DateTime($item['birthdate']));
            }

            if (array_key_exists('religion_id', $item)) {
                $religion = $this->getReference('religion-'.$item['religion_id']);
                $fixture->setReligion($em->merge($religion));
            }

            if ($ref=='rizqi') {
                $fixture->setCreated($this->todayMinus(10));
            }
            if ($ref=='aswil') {
                $fixture->setCreated($this->todayMinus(30));
            }
            if ($ref=='jos') {
                $fixture->setCreated($this->todayMinus(75));
            }

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('alumni-'.$item['aid'], $fixture);
        }

        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        $names = array('Anonymous Coward', 'Incognito Man', 'Fictious Girl');
        $titles = array(null, 'Mr.', 'Ms.');
        $genders = array(null, 'M', 'F');

        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $birthdate = (1855+$i).'-'.(($i % 12)+1).'-'.(($i % 30)+1);
            $updatedat = '2012-'.(($i % 12)+1).'-'.(($i % 30)+1);

            $fixture = new Alumni();
            $fixture
                ->setName($names[$i % 3].' '.$i)
                ->setPrefix($titles[$i % 3])
                ->setSuffix('STMJ')
                ->setGender($genders[$i % 3])
                ->setBirthdate(new \DateTime($birthdate))
                ->setCreated(new \DateTime('2012-06-01'))
                ->setUpdated(new \DateTime($updatedat));

            $em->persist($fixture);
            $this->addReference('alumni-anon-'. $i, $fixture);
        }

        $em->flush();
    }

    private function todayMinus($daydiff)
    {
        return new \DateTime(date('Y-m-d', time()-$daydiff*86400));
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '100_alumni';
    }

    public function getOrder()
    {
        return 100; // the order in which fixtures will be loaded
    }
}

