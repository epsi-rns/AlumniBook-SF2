<?php
// src/Iluni\BookBundle/DataFixtures/ORM/LoadBizFieldData.php
namespace Iluni\BookBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Iluni\BookBundle\DataFixtures\LoadBookData;
use Iluni\BookBundle\Entity\Category\BizField;

/**
 * Load data fixtures for a category entity
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LoadBizFieldData extends LoadBookData implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $fixtures = $this->getModelFixtures();
        $items = $fixtures['BizField'];

        // generator: { strategy: AUTO }
        $this->setForceId($em, new BizField());

        // Now iterate over all fixtures
        foreach ($items as $ref => $item) {
            $item_en = $item['Translation']['en'];
            $item_id = $item['Translation']['id'];

            $fixture = new BizField();
            $fixture
                ->setId($item['biz_field_id'])
                ->setName($item_en['biz_field']);
            //$repository->translate($fixture, 'name', 'id', $item_id['biz_field']);

            $em->persist($fixture);

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('biz_field-'. $ref, $fixture);
        }

        $em->flush();
    }

    /**
    *  The main fixtures file for this loader.
    */
    public function getModelFile()
    {
        return 'Category/050_biz_field';
    }

    public function getOrder()
    {
        return 50; // the order in which fixtures will be loaded
    }
}

