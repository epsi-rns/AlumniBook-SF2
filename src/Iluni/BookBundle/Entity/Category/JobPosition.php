<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\JobPosition
 */
class JobPosition
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
     * @return JobPosition
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
     * @return JobPosition
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */

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
     * @return JobPosition
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
}

