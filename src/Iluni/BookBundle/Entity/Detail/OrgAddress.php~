<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;
use Iluni\BookBundle\Entity\Base\Address;

/**
 * Iluni\BookBundle\Entity\Detail\OrgAddress
 */
class OrgAddress extends Address
{

    /**
     * @var Iluni\BookBundle\Entity\Organization
     */
    private $organization;


    /**
     * Set organization
     *
     * @param Iluni\BookBundle\Entity\Organization $organization
     * @return OAddress
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
}