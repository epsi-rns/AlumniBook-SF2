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
        $fixturesPath = realpath(dirname(__FILE__).'/../../../DataFixtures/Fixtures');
        $fixtures     = Yaml::parse(file_get_contents($fixturesPath. '/Category/'. $this->getModelFile(). '.yml'));

        return $fixtures;
    }
}

