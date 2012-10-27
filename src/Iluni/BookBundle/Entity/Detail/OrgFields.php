<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\OrgFields
 */
class OrgFields
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $product
     */
    private $product;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var Iluni\BookBundle\Entity\Category\BizField
     */
    private $bizField;


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
     * Set product
     *
     * @param string $product
     * @return Organization
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return OFields
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
     * @var Iluni\BookBundle\Entity\Organization
     */
    private $organization;


    /**
     * Set organization
     *
     * @param Iluni\BookBundle\Entity\Organization $organization
     * @return OFields
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
     * Set bizField
     *
     * @param Iluni\BookBundle\Entity\Category\BizField $bizField
     * @return OFields
     */
    public function setBizField(\Iluni\BookBundle\Entity\Category\BizField $bizField = null)
    {
        $this->bizField = $bizField;

        return $this;
    }

    /**
     * Get bizField
     *
     * @return Iluni\BookBundle\Entity\Category\BizField
     */
    public function getBizField()
    {
        return $this->bizField;
    }
}