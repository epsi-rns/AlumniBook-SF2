<?php

namespace Iluni\BookBundle\Library\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class LoadBookCategoryData extends LoadBookData implements ContainerAwareInterface
{
    /**
     * Return the fixtures for the current model.
     *
     * @return Array
     */
    public function getModelFixtures()
    {
        $kernel = $this->container->get('kernel');
        $path = $kernel->locateResource('@IluniBookBundle/DataFixtures/Fixtures/');
        $fixtures     = Yaml::parse(file_get_contents($path. '/Category/'. $this->getModelFile(). '.yml'));

        return $fixtures;
    }

    protected function setForceId($em, $fixture_class)
    {
        // should replace $fixture_class with new MyFixture::class ini PHP 5.5.

        $metadata = $em->getClassMetaData(get_class($fixture_class));
        $metadata->setIdGenerator(
            new \Doctrine\ORM\Id\AssignedGenerator()
        );
        $metadata->setIdGeneratorType(constant(
            '\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE'
        ));
    }
}

