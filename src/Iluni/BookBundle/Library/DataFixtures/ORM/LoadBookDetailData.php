<?php

namespace Iluni\BookBundle\Library\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class LoadBookDetailData extends LoadBookData implements ContainerAwareInterface
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
        $fixtures     = Yaml::parse(file_get_contents($path. '/Detail/'. $this->getModelFile(). '.yml'));

        return $fixtures;
    }
}
