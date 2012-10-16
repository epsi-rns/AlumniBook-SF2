<?php

namespace Iluni\BookBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Category\BizField
 */
class BizField
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
     * @var text $description
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $ofields;

    public function __construct()
    {
        $this->ofields = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param smallint $id
     * @return BizField
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
     * @return BizField
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
     * Set description
     *
     * @param text $description
     * @return BizField
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add ofields
     *
     * @param Iluni\BookBundle\Entity\Detail\OrgFields $ofields
     * @return BizField
     */
    public function addOfield(\Iluni\BookBundle\Entity\Detail\OrgFields $ofields)
    {
        $this->ofields[] = $ofields;

        return $this;
    }

    /**
     * Remove ofields
     *
     * @param Iluni\BookBundle\Entity\Detail\OrgFields $ofields
     */
    public function removeOfield(\Iluni\BookBundle\Entity\Detail\OrgFields $ofields)
    {
        $this->ofields->removeElement($ofields);
    }

    /**
     * Get ofields
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getOfields()
    {
        return $this->ofields;
    }
}

