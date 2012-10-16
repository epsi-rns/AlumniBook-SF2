<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniCertifications
 */
class AlumniCertifications
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $certification
     */
    private $certification;

    /**
     * @var string $institution
     */
    private $institution;

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
     * Set certification
     *
     * @param string $certification
     * @return ACertifications
     */
    public function setCertification($certification)
    {
        $this->certification = $certification;
        return $this;
    }

    /**
     * Get certification
     *
     * @return string
     */
    public function getCertification()
    {
        return $this->certification;
    }

    /**
     * Set institution
     *
     * @param string $institution
     * @return ACertifications
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
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return ACertifications
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

