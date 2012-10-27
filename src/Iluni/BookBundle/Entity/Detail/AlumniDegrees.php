<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniDegrees
 */
class AlumniDegrees
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var smallint $admitted
     */
    private $admitted;

    /**
     * @var smallint $graduated
     */
    private $graduated;

    /**
     * @var string $degree
     */
    private $degree;

    /**
     * @var string $institution
     */
    private $institution;

    /**
     * @var string $major
     */
    private $major;

    /**
     * @var string $minor
     */
    private $minor;

    /**
     * @var string $concentration
     */
    private $concentration;

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;

    /**
     * @var Iluni\BookBundle\Entity\Category\Strata
     */
    private $strata;

    public function __construct()
    {
        $this->degree       =   'ST';
        $this->institution  = 'University of Indonesia';
        $this->major        = 'Engineering';
    }

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
     * Set admitted
     *
     * @param smallint $admitted
     * @return ADegrees
     */
    public function setAdmitted($admitted)
    {
        $this->admitted = $admitted;
        return $this;
    }

    /**
     * Get admitted
     *
     * @return smallint
     */
    public function getAdmitted()
    {
        return $this->admitted;
    }

    /**
     * Set graduated
     *
     * @param smallint $graduated
     * @return ADegrees
     */
    public function setGraduated($graduated)
    {
        $this->graduated = $graduated;
        return $this;
    }

    /**
     * Get graduated
     *
     * @return smallint
     */
    public function getGraduated()
    {
        return $this->graduated;
    }

    /**
     * Set degree
     *
     * @param string $degree
     * @return ADegrees
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
        return $this;
    }

    /**
     * Get degree
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set institution
     *
     * @param string $institution
     * @return ADegrees
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set major
     *
     * @param string $major
     * @return ADegrees
     */
    public function setMajor($major)
    {
        $this->major = $major;
        return $this;
    }

    /**
     * Get major
     *
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Set minor
     *
     * @param string $minor
     * @return ADegrees
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;
        return $this;
    }

    /**
     * Get minor
     *
     * @return string
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * Set concentration
     *
     * @param string $concentration
     * @return ADegrees
     */
    public function setConcentration($concentration)
    {
        $this->concentration = $concentration;
        return $this;
    }

    /**
     * Get concentration
     *
     * @return string
     */
    public function getConcentration()
    {
        return $this->concentration;
    }

    /**
     * Set strata
     *
     * @param Iluni\BookBundle\Entity\Category\Strata $strata
     * @return ADegrees
     */
    public function setStrata(\Iluni\BookBundle\Entity\Category\Strata $strata = null)
    {
        $this->strata = $strata;
        return $this;
    }

    /**
     * Get strata
     *
     * @return Iluni\BookBundle\Entity\Category\Strata
     */
    public function getStrata()
    {
        return $this->strata;
    }

    /**
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return ADegrees
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