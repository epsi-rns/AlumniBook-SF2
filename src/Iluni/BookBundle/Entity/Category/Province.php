<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\Province
 */
class Province
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
     * Set id
     *
     * @param smallint $id
     * @return Province
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
     * @return Name
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