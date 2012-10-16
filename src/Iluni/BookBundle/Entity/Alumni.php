<?php

namespace Iluni\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Alumni
 */
class Alumni
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Iluni\BookBundle\Entity\Category\Religion
     */
    private $religion;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $prefix
     */
    private $prefix;

    /**
     * @var string $suffix
     */
    private $suffix;

    /**
     * @var text $note
     */
    private $note;

    /**
     * @var string $gender
     */
    private $gender;

    /**
     * @var string $birthplace
     */
    private $birthplace;

    /**
     * @var date $birthdate
     */
    private $birthdate;

    /**
     * @var string $fullname
     */
    private $fullname;

    /**
     * @var datetime $created
     */
    private $created;

    /**
     * @var datetime $updated
     */
    private $updated;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $acommunities;

    // ugly workaround
    private $viewcount = 0;

    public function __construct()
    {
        // constructor is never called by Doctrine

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
     * Set name
     *
     * @param string $name
     * @return Alumni
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
     * Set prefix
     *
     * @param string $prefix
     * @return Alumni
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set suffix
     *
     * @param string $suffix
     * @return Alumni
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set note
     *
     * @param text $note
     * @return Alumni
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return text
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Alumni
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    public function getGenderText()
    {
        $choice = array(null => 'Unknown', 'M' => 'Male', 'F' => 'Female');
        return $choice[$this->gender];
    }

    /**
     * Set birthplace
     *
     * @param string $birthplace
     * @return Alumni
     */
    public function setBirthplace($birthplace)
    {
        $this->birthplace = $birthplace;
        return $this;
    }

    /**
     * Get birthplace
     *
     * @return string
     */
    public function getBirthplace()
    {
        return $this->birthplace;
    }

    /**
     * Set birthdate
     *
     * @param date $birthdate
     * @return Alumni
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return date
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return Alumni
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }



    public function setFullnameValue()
    {
        $prefix = $this->prefix;
        $suffix = $this->suffix;
        $name = $this->name;

        if (!empty($prefix)) {
            $name = $prefix.' '.$name;
        }
        if (!empty($suffix)) {
            $name = $name.', '.$suffix;
        }

        $this->fullname = $name;
    }

    /**
     * Set religion
     *
     * @param Iluni\BookBundle\Entity\Category\Religion $religion
     * @return Alumni
     */
    public function setReligion(\Iluni\BookBundle\Entity\Category\Religion $religion = null)
    {
        $this->religion = $religion;
        return $this;
    }

    /**
     * Get religion
     *
     * @return Iluni\BookBundle\Entity\Category\Religion
     */
    public function getReligion()
    {
        return $this->religion;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getCommunity($index = 0)
    {
        // getFirst equivalent, use this with care
        return $this->acommunities[$index];
    }

    public function getCommunityWalk()
    {
        return $this->acommunities[$this->viewcount++];
    }

    public function getCommunityText()
    {
        $comies = array();

        $communities = $this->acommunities;
        foreach ($communities as $community) {
            $comy = $community->getCommunity();
            $year = $community->getClassYear();
            // $text = $this->textShort($comy, 15);

            if (!empty($year)) {
                $text = $year.' - '.$comy;
            }
            $comies[] = $text;
        }

        $text_comy = implode('<br/>', $comies);
        return $text_comy;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return Alumni
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     * @return Alumni
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add acommunities
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities
     * @return Alumni
     */
    public function addAcommunitie(\Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities)
    {
        $this->acommunities[] = $acommunities;

        return $this;
    }

    /**
     * Remove acommunities
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities
     */
    public function removeAcommunitie(\Iluni\BookBundle\Entity\Detail\AlumniCommunities $acommunities)
    {
        $this->acommunities->removeElement($acommunities);
    }

    /**
     * Get acommunities
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAcommunities()
    {
        return $this->acommunities;
    }
}

