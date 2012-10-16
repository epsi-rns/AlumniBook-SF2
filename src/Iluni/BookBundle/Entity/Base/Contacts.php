<?php

namespace Iluni\BookBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Base\Contacts
 */
class Contacts
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $contact
     */
    private $contact;

    /**
     * @var Iluni\BookBundle\Entity\Category\ContactType
     */
    private $contactType;


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
     * Set contact
     *
     * @param string $contact
     * @return Contacts
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set contactType
     *
     * @param Iluni\BookBundle\Entity\Category\ContactType $contactType
     * @return Contacts
     */
    public function setContactType(\Iluni\BookBundle\Entity\Category\ContactType $contactType = null)
    {
        $this->contactType = $contactType;
        return $this;
    }

    /**
     * Get contactType
     *
     * @return Iluni\BookBundle\Entity\Category\ContactType
     */
    public function getContactType()
    {
        return $this->contactType;
    }
}

