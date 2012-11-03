<?php

namespace Iluni\BookBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class LoadBookData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Return the file for the current model.
     */
    abstract public function getModelFile();

    /**
     * Make the sc available to our loader.
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Return the fixtures for the current model.
     *
     * @return Array
     */
    public function getModelFixtures()
    {
        $bundlepath = '@IluniBookBundle/DataFixtures/Fixtures/';
        $kernel = $this->container->get('kernel');
        $basepath = $kernel->locateResource($bundlepath);

        $path = $basepath. '/'. $this->getModelFile(). '.yml';
        $content  = file_get_contents($path);
        $fixtures = Yaml::parse($content);

        return $fixtures;
    }

    /**
     * Helper Method: changing generator type on the fly.
     */
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

