<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniCommunities
 */
class AlumniCommunities
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var smallint $classYear
     */
    private $classYear;

    /**
     * @var string $classSub
     */
    private $classSub;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;

    /**
     * @var Iluni\BookBundle\Entity\Community
     */
    private $community;

    /**
     * @var Iluni\BookBundle\Entity\Category\Department
     */
    private $department;

    /**
     * @var Iluni\BookBundle\Entity\Category\Faculty
     */
    private $faculty;

    /**
     * @var Iluni\BookBundle\Entity\Category\Program
     */
    private $program;


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
     * Set classYear
     *
     * @param smallint $classYear
     * @return ACommunities
     */
    public function setClassYear($classYear)
    {
        $this->classYear = $classYear;
        return $this;
    }

    /**
     * Get classYear
     *
     * @return smallint
     */
    public function getClassYear()
    {
        return $this->classYear;
    }

    /**
     * Set classSub
     *
     * @param string $classSub
     * @return ACommunities
     */
    public function setClassSub($classSub)
    {
        $this->classSub = $classSub;
        return $this;
    }

    /**
     * Get classSub
     *
     * @return string
     */
    public function getClassSub()
    {
        return $this->classSub;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ACommunities
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
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return ACommunities
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
     * Set community
     *
     * @param Iluni\BookBundle\Entity\Community $community
     * @return ACommunities
     */
    public function setCommunity(\Iluni\BookBundle\Entity\Community $community = null)
    {
        $this->community = $community;
        return $this;
    }

    /**
     * Get community
     *
     * @return Iluni\BookBundle\Entity\Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set department
     *
     * @param Iluni\BookBundle\Entity\Category\Department $department
     * @return ACommunities
     */
    public function setDepartment(\Iluni\BookBundle\Entity\Category\Department $department = null)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * Get department
     *
     * @return Iluni\BookBundle\Entity\Category\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set faculty
     *
     * @param Iluni\BookBundle\Entity\Category\Faculty $faculty
     * @return ACommunities
     */
    public function setFaculty(\Iluni\BookBundle\Entity\Category\Faculty $faculty = null)
    {
        $this->faculty = $faculty;
        return $this;
    }

    /**
     * Get faculty
     *
     * @return Iluni\BookBundle\Entity\Category\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set program
     *
     * @param Iluni\BookBundle\Entity\Category\Program $program
     * @return ACommunities
     */
    public function setProgram(\Iluni\BookBundle\Entity\Category\Program $program = null)
    {
        $this->program = $program;
        return $this;
    }

    /**
     * Get program
     *
     * @return Iluni\BookBundle\Entity\Category\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    public function setCommunityNameValue()
    {
        // Add your code here
        $community = $this->getCommunity();

        // copy shortcut value
        $this->setFaculty($community->getFaculty());
        $this->setDepartment($community->getDepartment());
        $this->setProgram($community->getProgram());

        // Calculated field
        $year = $this->classYear;
        $brief = $community->getBrief();
        if (empty($brief)) {
            $alias =  $community->getName();
        } else {
            $alias = $brief;
            $year = substr($year, 2, 2);
        }


        if (!empty($this->classSub)) {
            $year = $year.' ('.$this->classSub.')';
        }

        if (!empty($year)   ) {
            $alias = $alias.' - '.$year;
        }

        $this->name = $alias;
    }

    public function getRefText()
    {
        $text = $this->getCommunity();
        $year = $this->getClassYear();
        $sub = $this->getClassSub();
        if (!empty($year)) {
            $text .=  ' - '.$year;
        }
        if (!empty($sub)) {
            $text .=  ' ('.$sub.')';
        }

        return $text;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

