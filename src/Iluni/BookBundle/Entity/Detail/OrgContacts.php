<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;
use Iluni\BookBundle\Entity\Base\Contacts;

/**
 * Iluni\BookBundle\Entity\Detail\OrgContacts
 */
class OrgContacts extends Contacts
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

