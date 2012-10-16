<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniOrgMap
 */
class AlumniOrgMap
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $department
     */
    private $department;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $struktural
     */
    private $struktural;

    /**
     * @var string $fungsional
     */
    private $fungsional;

    /**
     * @var datetime $createdAt
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     */
    private $updatedAt;

    public function __construct()
    {
        // constructor is never called by Doctrine
        $this->createdAt = $this->updatedAt = new \DateTime();
    }
    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $aid;

    /**
     * @var Iluni\BookBundle\Entity\Organization
     */
    private $oid;

    /**
     * @var Iluni\BookBundle\Entity\Category\JobPosition
     */
    private $jobPosition;

    /**
     * @var Iluni\BookBundle\Entity\Category\JobType
     */
    private $jobType;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return AlumniOrgMap
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AlumniOrgMap
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set struktural
     *
     * @param string $struktural
     * @return AlumniOrgMap
     */
    public function setStruktural($struktural)
    {
        $this->struktural = $struktural;
        return $this;
    }

    /**
     * Get struktural
     *
     * @return string
     */
    public function getStruktural()
    {
        return $this->struktural;
    }

    /**
     * Set fungsional
     *
     * @param string $fungsional
     * @return AlumniOrgMap
     */
    public function setFungsional($fungsional)
    {
        $this->fungsional = $fungsional;
        return $this;
    }

    /**
     * Get fungsional
     *
     * @return string
     */
    public function getFungsional()
    {
        return $this->fungsional;
    }

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;

    /**
     * @var Iluni\BookBundle\Entity\Organization
     */
    private $organization;


    /**
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return AlumniOrgMap
     */
    public function setAlumni(\Iluni\BookBundle\Entity\Alumni $alumni = null)
    {
        $this->alumni = $alumni;
        return $this;
    }

    /**
     * Get alumni
     *
     * @return Iluni\BookBundle\Entity\Alumni
     */
    public function getAlumni()
    {
        return $this->alumni;
    }

    /**
     * Set organization
     *
     * @param Iluni\BookBundle\Entity\Organization $organization
     * @return AlumniOrgMap
     */
    public function setOrganization(\Iluni\BookBundle\Entity\Organization $organization = null)
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * Get organization
     *
     * @return Iluni\BookBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @var \DateTime $created
     */
    private $created;

    /**
     * @var \DateTime $updated
     */
    private $updated;


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return AlumniOrgMap
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return AlumniOrgMap
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set jobPosition
     *
     * @param Iluni\BookBundle\Entity\Category\JobPosition $jobPosition
     * @return AlumniOrgMap
     */
    public function setJobPosition(\Iluni\BookBundle\Entity\Category\JobPosition $jobPosition = null)
    {
        $this->jobPosition = $jobPosition;

        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return Iluni\BookBundle\Entity\Category\JobPosition
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set jobType
     *
     * @param Iluni\BookBundle\Entity\Category\JobType $jobType
     * @return AlumniOrgMap
     */
    public function setJobType(\Iluni\BookBundle\Entity\Category\JobType $jobType = null)
    {
        $this->jobType = $jobType;

        return $this;
    }

    /**
     * Get jobType
     *
     * @return Iluni\BookBundle\Entity\Category\JobType
     */
    public function getJobType()
    {
        return $this->jobType;
    }
}

