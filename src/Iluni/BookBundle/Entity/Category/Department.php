<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\Department
 */
class Department
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
     * @var Iluni\BookBundle\Entity\Category\Faculty
     */
    private $faculty;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $community;

    /**
     * Set id
     *
     * @param smallint $id
     * @return Department
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
     * @return Department
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
     * Set faculty
     *
     * @param Iluni\BookBundle\Entity\Category\Faculty $faculty
     * @return Department
     */
    public function setFaculty(\Iluni\BookBundle\Entity\Category\Faculty $faculty = null)
    {
        $this->faculty = $faculty;
        return $this;
    }

    /**
     * Get faculty
     *
     * @return Iluni\BookBundle\Entity\Category\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->community = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add community
     *
     * @param Iluni\BookBundle\Entity\Community $community
     * @return Department
     */
    public function addCommunity(\Iluni\BookBundle\Entity\Community $community)
    {
        $this->community[] = $community;

        return $this;
    }

    /**
     * Remove community
     *
     * @param Iluni\BookBundle\Entity\Community $community
     */
    public function removeCommunity(\Iluni\BookBundle\Entity\Community $community)
    {
        $this->community->removeElement($community);
    }

    /**
     * Get community
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCommunity()
    {
        return $this->community;
    }

}