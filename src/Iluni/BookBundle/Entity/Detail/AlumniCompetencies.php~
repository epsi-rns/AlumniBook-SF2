<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniCompetencies
 */
class AlumniCompetencies
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;

    /**
     * @var Iluni\BookBundle\Entity\Category\Competency
     */
    private $competency;


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
     * Set description
     *
     * @param string $description
     * @return ACompetencies
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
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return ACompetencies
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
     * Set competency
     *
     * @param Iluni\BookBundle\Entity\Category\Competency $competency
     * @return ACompetencies
     */
    public function setCompetency(\Iluni\BookBundle\Entity\Category\Competency $competency = null)
    {
        $this->competency = $competency;

        return $this;
    }

    /**
     * Get competency
     *
     * @return Iluni\BookBundle\Entity\Category\Competency
     */
    public function getCompetency()
    {
        return $this->competency;
    }
}