<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\Competency
 */
class Competency
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
     * @var text $memo
     */
    private $memo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $acompetencies;

    public function __construct()
    {
        $this->acompetencies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param smallint $id
     * @return Competency
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
     * @return Competency
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
     * Set memo
     *
     * @param text $memo
     * @return Competency
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
        return $this;
    }

    /**
     * Get memo
     *
     * @return text
     */
    public function getMemo()
    {
        return $this->memo;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add acompetencies
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCompetencies $acompetencies
     * @return Competency
     */
    public function addAcompetencie(\Iluni\BookBundle\Entity\Detail\AlumniCompetencies $acompetencies)
    {
        $this->acompetencies[] = $acompetencies;

        return $this;
    }

    /**
     * Remove acompetencies
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCompetencies $acompetencies
     */
    public function removeAcompetencie(\Iluni\BookBundle\Entity\Detail\AlumniCompetencies $acompetencies)
    {
        $this->acompetencies->removeElement($acompetencies);
    }

    /**
     * Get acompetencies
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAcompetencies()
    {
        return $this->acompetencies;
    }
}

