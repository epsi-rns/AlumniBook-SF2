<?php

namespace Iluni\BookBundle\Library\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class LoadBookData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * Return the file for the current model.
     */
    abstract public function getModelFile();

    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

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
        $kernel = $this->container->get('kernel');
        $path = $kernel->locateResource('@IluniBookBundle/DataFixtures/Fixtures/');
        $fixtures     = Yaml::parse(file_get_contents($path. '/'. $this->getModelFile(). '.yml'));

        return $fixtures;
    }
}

