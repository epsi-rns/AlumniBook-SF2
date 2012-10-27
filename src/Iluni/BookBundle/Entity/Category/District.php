<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\District
 */
class District
{
    /**
     * @var smallint $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var Iluni\BookBundle\Entity\Category\Province
     */
    private $province;

    /**
     * Set id
     *
     * @param smallint $id
     * @return District
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return smallint
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return District
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set province
     *
     * @param Iluni\BookBundle\Entity\Category\Province $province
     * @return District
     */
    public function setProvince(\Iluni\BookBundle\Entity\Category\Province $province = null)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * Get province
     *
     * @return Iluni\BookBundle\Entity\Category\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function preventDelete()
    {
        if ($this->id <= 0) {
            throw new \Exception('avoid delete');
        }
    }
}