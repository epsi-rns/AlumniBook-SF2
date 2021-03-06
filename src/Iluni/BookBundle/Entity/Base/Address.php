<?php

namespace Iluni\BookBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Iluni\BookBundle\Entity\Base\Address
 */
class Address
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $area
     */
    private $area;

    /**
     * @var string $building
     */
    private $building;

    /**
     * @var string $street
     */
    private $street;

    /**
     * @var string $postalCode
     */
    private $postalCode;

    /**
     * @var string $address
     */
    private $address;

    /**
     * @var string $region
     */
    private $region;

    /**
     * @var Iluni\BookBundle\Entity\Category\Country
     */
    private $country;

    /**
     * @var Iluni\BookBundle\Entity\Category\Province
     */
    private $province;

    /**
     * @var Iluni\BookBundle\Entity\Category\District
     */
    private $district;


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
     * Set area
     *
     * @param string $area
     * @return Address
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set building
     *
     * @param string $building
     * @return Address
     */
    public function setBuilding($building)
    {
        $this->building = $building;
        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Address
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    public function setFullAddressValue()
    {
        // address part
        $address = array();
        if (!empty($this->building)) {
            $address[] = $this->building;
        }
        if (!empty($this->street)) {
            $address[] = $this->street;
        }
        if (!empty($this->area)) {
            $address[] = $this->area;
        }

        $this->address = trim(implode(', ', $address));

        // region part
        $region = array();

        if ($this->district) {
            $region[] = $this->district;
        }
        if ($this->province) {
            $region[] = $this->province;
        }
        if ($this->country) {
            $region[] = $this->country;
        }
        if ($this->postalCode) {
            $region[] = $this->postalCode;
        }

        $this->region = trim(implode(', ', $region));
    }

    /**
     * Set country
     *
     * @param Iluni\BookBundle\Entity\Category\Country $country
     * @return Address
     */
    public function setCountry(\Iluni\BookBundle\Entity\Category\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return Iluni\BookBundle\Entity\Category\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set province
     *
     * @param Iluni\BookBundle\Entity\Category\Province $province
     * @return Address
     */
    public function setProvince(\Iluni\BookBundle\Entity\Category\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return Iluni\BookBundle\Entity\Category\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set district
     *
     * @param Iluni\BookBundle\Entity\Category\District $district
     * @return Address
     */
    public function setDistrict(\Iluni\BookBundle\Entity\Category\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return Iluni\BookBundle\Entity\Category\District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    public function isCombinationValid(ExecutionContext $context)
    {
        if (! ($this->area
            || $this->building
            || $this->street) ) {

            $message = 'Address is empty.';
            $context->addViolation($message, array(), null);
        }

        if ($this->country==null
            && $this->province==null
            && $this->district==null
            && !$this->postalCode) {

            $message = 'Region is empty.';
            $context->addViolation($message, array(), null);
        }
    }
}