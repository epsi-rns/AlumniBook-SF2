<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniExperiences
 */
class AlumniExperiences
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $organization
     */
    private $organization;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $jobPosition
     */
    private $jobPosition;

    /**
     * @var smallint $yearIn
     */
    private $yearIn;

    /**
     * @var smallint $yearOut
     */
    private $yearOut;

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;


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
     * Set organization
     *
     * @param string $organization
     * @return AExperiences
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * Get organization
     *
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AExperiences
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
     * Set jobPosition
     *
     * @param string $jobPosition
     * @return AExperiences
     */
    public function setJobPosition($jobPosition)
    {
        $this->jobPosition = $jobPosition;
        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return string
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set yearIn
     *
     * @param smallint $yearIn
     * @return AExperiences
     */
    public function setYearIn($yearIn)
    {
        $this->yearIn = $yearIn;
        return $this;
    }

    /**
     * Get yearIn
     *
     * @return smallint
     */
    public function getYearIn()
    {
        return $this->yearIn;
    }

    /**
     * Set yearOut
     *
     * @param smallint $yearOut
     * @return AExperiences
     */
    public function setYearOut($yearOut)
    {
        $this->yearOut = $yearOut;
        return $this;
    }

    /**
     * Get yearOut
     *
     * @return smallint
     */
    public function getYearOut()
    {
        return $this->yearOut;
    }

    /**
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return AExperiences
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
}