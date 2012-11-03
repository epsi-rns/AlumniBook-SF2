<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadOFieldsData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Detail\OrgFields;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadOrgFieldsData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['OFields'];
        $this->loadItems($em, $items);
        $this->loadGenerated($em);
    }

    private function loadItems(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new OrgFields();

            $ref_oid    = $this->getReference('org-'.$item['oid']);
            $ref_xid    = $this->getReference('biz_field-'.$item['biz_field_id']);

            $fixture
                ->setOrganization($em->merge($ref_oid))
                ->setBizField($em->merge($ref_xid));

            if (array_key_exists('product', $item)) {
                $fixture->setProduct($item['product']);
            }

            if (array_key_exists('description', $item)) {
                $fixture->setDescription($item['description']);
            }

            $em->persist($fixture);
        }
        $em->flush();
    }

    private function loadGenerated(ObjectManager $em)
    {
        $productTemplate = array(0=>'Produk', 1=>'Jasa', 2=>'Dagang', 3=>'Olahan');

        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $mod = $i % 4;

            $fixture = new OrgFields();

            $ref_oid    = $this->getReference('org-fake-'.$i);
            $ref_xid    = $this->getReference('biz_field-'.(($i % 25) + 1));

            $fixture
                ->setOrganization($em->merge($ref_oid))
                ->setBizField($em->merge($ref_xid))
                ->setProduct($productTemplate[$mod].' '.$i)
                ->setDescription('Keterangan-'.$i);


            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Detail/220_ofields';
    }

    public function getOrder()
    {
        return 220; // the order in which fixtures will be loaded
    }
}

