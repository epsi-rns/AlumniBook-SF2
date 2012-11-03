<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadContactsData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Detail\AlumniContacts;
use Iluni\BookBundle\Entity\Detail\OrgContacts;
use Iluni\BookBundle\Entity\Detail\MapContacts;

/**
 * Load data fixtures for a detail entity in master-detail-relationship
 * Each fixtures using reference from master fixture
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadContactsData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();

        $items = $fixtures['AContacts'];
        $this->loadItemsAlumniContact($em, $items);
        $this->loadGeneratedAlumniContact($em);

        $items = $fixtures['OContacts'];
        $this->loadItemsOrgContact($em, $items);
        $this->loadGeneratedOrgContact($em);

        $items = $fixtures['MContacts'];
        $this->loadItemsMapContact($em, $items);
        $this->loadGeneratedMapContact($em);
    }

    private function loadItemsAlumniContact(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new AlumniContacts();

            $ref_aid    = $this->getReference('alumni-'.$item['aid']);
            $fixture->setAlumni($em->merge($ref_aid));

            $this->loadItemContacts($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemsOrgContact(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new OrgContacts();

            $ref_oid    = $this->getReference('org-'.$item['oid']);
            $fixture->setOrganization($em->merge($ref_oid));

            $this->loadItemContacts($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemsMapContact(ObjectManager $em, $items)
    {
        // Now iterate over all fixtures from yaml
        foreach ($items as $ref => $item) {
            $fixture = new MapContacts();

            $ref_mid    = $this->getReference('ao_map-'.$item['mid']);
            $fixture->setAlumniOrgMap($em->merge($ref_mid));

            $this->loadItemContacts($em, $item, $fixture);

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadItemContacts(ObjectManager $em, $item, $fixture)
    {
        $ref_ct_id  = $this->getReference('contact_type-'.$item['ct_id']);
        $fixture
            ->setContactType($em->merge($ref_ct_id))
            ->setContact($item['contact']);
    }

    private function loadGeneratedAlumniContact(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new AlumniContacts();
            $ref_aid    = $this->getReference('alumni-anon-'.$i);

            $id = ($i % 5) + 1;
            $ref_ct_id  = $this->getReference('contact_type-'.$id);

            $fixture
                ->setAlumni($em->merge($ref_aid))
                ->setContactType($em->merge($ref_ct_id))
                ->setContact($this->getContact($id, $i).' (aa)');

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadGeneratedOrgContact(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new OrgContacts();
            $ref_oid    = $this->getReference('org-fake-'.$i);

            $id = ($i % 5) + 1;
            $ref_ct_id  = $this->getReference('contact_type-'.$id);

            $fixture
                ->setOrganization($em->merge($ref_oid))
                ->setContactType($em->merge($ref_ct_id))
                ->setContact($this->getContact($id, $i).' (oo)');

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function loadGeneratedMapContact(ObjectManager $em)
    {
        // Now iterate over all script-generated fixtures
        for ($i = 100; $i <= 130; $i++) {
            $fixture = new MapContacts();
            $ref_mid    = $this->getReference('ao_map-'.$i);

            $id = ($i % 5) + 1;
            $ref_ct_id  = $this->getReference('contact_type-'.$id);

            $fixture
                ->setAlumniOrgMap($em->merge($ref_mid))
                ->setContactType($em->merge($ref_ct_id))
                ->setContact($this->getContact($id, $i).' (mm)');

            $em->persist($fixture);
        }

        $em->flush();
    }

    private function getContact($id, $i)
    {
        switch ($id) {
            case 3:
                $contact = '081xy-0'.$i.'-0'.$i;
                break;
            case 4:
                $contact = '021xy-'.$i.'-0'.$i;
                break;
            case 5:
                $contact = '021xy-0'.$i.'-'.$i;
                break;
            case 8:
                $contact = 'fake.'.$i.'@demo.iluni.org';
                break;
            case 9:
                $contact = 'user'.$i.'.iluni-ftui.org';
                break;
            default:
                $contact = 'test-'.$i;
        }
        return $contact;
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Detail/320_contacts';
    }

    public function getOrder()
    {
        return 320; // the order in which fixtures will be loaded
    }
}

