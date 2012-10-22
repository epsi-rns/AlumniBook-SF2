<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadUserData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\Library\DataFixtures\ORM\LoadBookData;
use Iluni\BookBundle\Entity\User;

/**
 * Load data fixtures for an entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadUserData extends LoadBookData implements OrderedFixtureInterface
{

    public function load(ObjectManager $em)
    {
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Users'];

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $fixture = new User();
            $fixture
                ->setUsername($item['username'])
                ->setEmail($item['email'])
                ->setPassword(sha1($item['password']))
                ->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36))
                ->setRoles(array($item['roles']));

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('user-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return '400_users';
    }

    public function getOrder()
    {
        return 400; // the order in which fixtures will be loaded
    }
}

