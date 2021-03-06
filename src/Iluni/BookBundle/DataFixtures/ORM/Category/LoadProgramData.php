<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadProgramData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\Program;

#use Stof\DoctrineExtensionsBundle\DependencyInjection\StofDoctrineExtensionsExtension;
use Gedmo\Translatable\Entity\Translation;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadProgramData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        // entities are not in the bundle anymore in master (which is for Symfony 2.1).
        // $repository = $em->getRepository('StofDoctrineExtensionsBundle:Translation');

        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['Program'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new Program());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new Program();
            $fixture
                ->setId($item['program_id'])
                ->setName($item_en['program']);
            $repository->translate($fixture, 'name', 'id', $item_id['program']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('program-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/020_program';
    }

    public function getOrder()
    {
        return 20; // the order in which fixtures will be loaded
    }
}

