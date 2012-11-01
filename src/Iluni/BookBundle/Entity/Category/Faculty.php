<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\Faculty
 */
class Faculty
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $departments;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $community;

    /**
     * Set id
     *
     * @param smallint $id
     * @return Faculty
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
     * @return Faculty
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->department = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add departments
     *
     * @param Iluni\BookBundle\Entity\Category\Department $departments
     * @return Faculty
     */
    public function addDepartment(\Iluni\BookBundle\Entity\Category\Department $departments)
    {
        $this->departments[] = $departments;

        return $this;
    }

    /**
     * Remove departments
     *
     * @param Iluni\BookBundle\Entity\Category\Department $departments
     */
    public function removeDepartment(\Iluni\BookBundle\Entity\Category\Department $departments)
    {
        $this->departments->removeElement($departments);
    }

    /**
     * Get departments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * Add community
     *
     * @param Iluni\BookBundle\Entity\Community $community
     * @return Faculty
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