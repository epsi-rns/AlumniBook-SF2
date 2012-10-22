<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadAddressData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookDetailData;
use Iluni\BookBundle\Entity\Detail\AlumniAddress;
use Iluni\BookBundle\Entity\Detail\OrgAddress;
use Iluni\BookBundle\Entity\Detail\MapAddress;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadAddressData extends LoadBookDetailData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();

        $items = $fixtures['AAddress'];
        $this->loadItemsAlumniAddress($em, $items);
        $this->loadGeneratedAlumniAddress($em);

        $items = $fixtures['OAddress'];
        $this->loadItemsOrgAddress($em, $items);
        $this->loadGeneratedOrgAddress($em);

        $items = $fixtures['MAddress'];
        $this->loadItemsMapAddress($em, $items);
        $this->loadGeneratedMapAddress($em);
    }

    private function loadItemsAlumniAddress(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new AlumniAddress();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);
            $fixture->setAlumni($em->merge($ref_aid));

            $this->loadItemAddress($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemsOrgAddress(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new OrgAddress();

            $ref_oid    = $this->getReference('org-'.$item['oid']);
            $fixture->setOrganization($em->merge($ref_oid));

            $this->loadItemAddress($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemsMapAddress(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new MapAddress();

            $ref_mid    = $this->getReference('ao_map-'.$item['mid']);
            $fixture->setAlumniOrgMap($em->merge($ref_mid));

            $this->loadItemAddress($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemAddress(ObjectManager $em, $item, $fixture)
    {
        $columns = array('area', 'building', 'street');

        foreach ($columns as $column) {
            if (array_key_exists($column, $item)) {
                $method = 'set'.ucfirst($column);
                $fixture->$method($item[$column]);
            }
        }

        if (array_key_exists('postal_code', $item)) {
            $fixture->setPostalCode($item['postal_code']);
        }

        if (array_key_exists('province_id', $item)) {
            $province = $this->getReference('province-'.$item['province_id']);
            $fixture->setProvince($em->merge($province));
        }

        if (array_key_exists('district_id', $item)) {
            $district = $this->getReference('district-'.$item['district_id']);
            $fixture->setDistrict($em->merge($district));
        }

        if (array_key_exists('country_id', $item)) {
            $country = $this->getReference('country-'.$item['country_id']);
            $fixture->setCountry($em->merge($country));
        }
    }

    private function loadGeneratedAlumniAddress(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 110; $i++) {
            $fixture  = new AlumniAddress();
            $ref_aid  = $this->getReference('alumni-anon-'.$i);
            $province = $this->getReference('province-'.(13));
            $district = $this->getReference('district-'.(($i % 5)+166));

            $area = (($i % 2)? 'Region-':'Area-').$i;
            $street = (($i % 2)? 'Street':'Road').' no. '.$i;

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setArea($area)
                ->setStreet($street)
                ->setBuilding('Apartment-'.$i)
                ->setProvince($em->merge($province))
                ->setDistrict($em->merge($district));

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadGeneratedOrgAddress(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 111; $i <= 120; $i++) {
            $fixture  = new OrgAddress();
            $ref_oid  = $this->getReference('org-fake-'.$i);
            $province = $this->getReference('province-'.(13));
            $district = $this->getReference('district-'.(($i % 5)+166));

            $area = (($i % 2)? 'Region-':'Area-').$i;
            $street = (($i % 2)? 'Street':'Road').' no. '.$i;

            $fixture
                ->setOrganization($em->merge($ref_oid))
                ->setArea($area)
                ->setStreet($street)
                ->setProvince($em->merge($province))
                ->setDistrict($em->merge($district));

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadGeneratedMapAddress(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 121; $i <= 130; $i++) {
            $fixture  = new MapAddress();
            $ref_mid  = $this->getReference('ao_map-'.$i);
            $province = $this->getReference('province-'.(13));
            $district = $this->getReference('district-'.(($i % 5)+166));

            $area = (($i % 2)? 'Region-':'Area-').$i;
            $street = (($i % 2)? 'Street':'Road').' no. '.$i;

            $fixture
                ->setAlumniOrgMap($em->merge($ref_mid))
                ->setArea($area)
                ->setStreet($street)
                ->setProvince($em->merge($province))
                ->setDistrict($em->merge($district));

            $em->persist($fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '310_address';
    }

    public function getOrder()
    {
        return 310; // the order in which fixtures will be loaded
    }
}

