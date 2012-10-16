<?php

namespace Iluni\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Community
 */
class Community
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
     * @var string $brief
     */
    private $brief;

    /**
     * @var smallint $typeId
     */
    private $typeId;

    /**
     * @var Iluni\BookBundle\Entity\Category\Department
     */
    private $department;

    /**
     * @var Iluni\BookBundle\Entity\Category\Faculty
     */
    private $faculty;

    /**
     * @var Iluni\BookBundle\Entity\Category\Program
     */
    private $program;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $acommunities;

    public function __construct()
    {
        $this->acommunities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param smallint $id
     * @return Community
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
     * @return Community
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
     * Set brief
     *
     * @param string $brief
     * @return Community
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;
        return $this;
    }

    /**
     * Get brief
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set typeId
     *
     * @param smallint $typeId
     * @return Community
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
        return $this;
    }

    /**
     * Get typeId
     *
     * @return smallint
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set department
     *
     * @param Iluni\BookBundle\Entity\Category\Department $department
     * @return Community
     */
    public function setDepartment(\Iluni\BookBundle\Entity\Category\Department $department = null)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * Get department
     *
     * @return Iluni\BookBundle\Entity\Category\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set faculty
     *
     * @param Iluni\BookBundle\Entity\Category\Faculty $faculty
     * @return Community
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

    /**
     * Set program
     *
     * @param Iluni\BookBundle\Entity\Category\Program $program
     * @return Community
     */
    public function setProgram(\Iluni\BookBundle\Entity\Category\Program $program = null)
    {
        $this->program = $program;
        return $this;
    }

    /**
     * Get program
     *
     * @return Iluni\BookBundle\Entity\Category\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add acommunities
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities
     * @return Community
     */
    public function addAcommunitie(\Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities)
    {
        $this->acommunities[] = $acommunities;

        return $this;
    }

    /**
     * Remove acommunities
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities
     */
    public function removeAcommunitie(\Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities)
    {
        $this->acommunities->removeElement($acommunities);
    }

    /**
     * Get acommunities
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAcommunities()
    {
        return $this->acommunities;
    }
}