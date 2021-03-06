<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\JobType
 */
class JobType
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
     * @return JobType
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
     * @return JobType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get jobType
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $alumni_org_map;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->alumni_org_map = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add alumni_org_map
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap
     * @return JobType
     */
    public function addAlumniOrgMap(\Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap)
    {
        $this->alumni_org_map[] = $alumniOrgMap;

        return $this;
    }

    /**
     * Remove alumni_org_map
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap
     */
    public function removeAlumniOrgMap(\Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap)
    {
        $this->alumni_org_map->removeElement($alumniOrgMap);
    }

    /**
     * Get alumni_org_map
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAlumniOrgMap()
    {
        return $this->alumni_org_map;
    }

    public function preventDelete()
    {
        if ($this->id <= 2) {
            throw new \Exception('avoid delete');
        }
    }
}