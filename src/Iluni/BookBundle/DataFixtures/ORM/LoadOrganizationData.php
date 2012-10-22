<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadOrganizationData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookData;
use Iluni\BookBundle\Entity\Organization;

/**
 * Load data fixtures for an entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadOrganizationData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Organization'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    // walk through recursive nodes
    private function loadItems(ObjectManager $em, $items, $parent = null)
    {
        $columns = array('name', 'prefix', 'suffix', 'note');

        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new Organization();

            if ($parent) {
                $fixture->setParent($parent);
            }

            foreach ($columns as $column) {
                if (array_key_exists($column, $item)) {
                    $method = 'set'.ucfirst($column);
                    $fixture->$method($item[$column]);
                }
            }

            $em->persist($fixture);

            if (array_key_exists('oid', $item)) {
                // Add a reference to be able to use this object in others entities loaders
                $this->addReference('org-'.$item['oid'], $fixture);
            }

            if (array_key_exists('children', $item)) {
                $children = $item['children'];
                $this->loadItems($em, $children, $fixture);
            }
        }

        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        $nameTemplate = array(0=>'Induk Usaha', 1=>'Toko', 2=>'Usaha', 3=>'Pabrik');
        $prefixTemplate = array(0=>'PT.', 1=>'PD.', 2=>'CV.', 3=>'UD.');
        $noteTemplate = array(0=>'Holding Company', 1=>'Shop', 2=>'Small Services Business', 3=>'Home Industry');

        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $mod = $i % 4;
            $updatedat = '2012-'.(($i % 12)+1).'-'.(($i % 30)+1);

            $fixture = new Organization();
            if ($mod==0) {
                $root = $fixture;
            } else {
                $fixture->setParent($root);
            }

            $fixture
                ->setName($nameTemplate[$mod].' '.$i)
                ->setPrefix($prefixTemplate[$mod])
                ->setNote($noteTemplate[$mod])
                ->setCreated(new \DateTime('2012-06-01'))
                ->setUpdated(new \DateTime($updatedat));

            $em->persist($fixture);
            $this->addReference('org-fake-'. $i, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '200_organization';
    }

    public function getOrder()
    {
        return 200; // the order in which fixtures will be loaded
    }
}

