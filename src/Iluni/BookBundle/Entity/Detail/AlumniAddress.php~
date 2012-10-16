<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;
use Iluni\BookBundle\Entity\Base\Address;

/**
 * Iluni\BookBundle\Entity\Detail\AlumniAddress
 */
class AlumniAddress extends Address
{

    /**
     * @var Iluni\BookBundle\Entity\Alumni
     */
    private $alumni;


    /**
     * Set alumni
     *
     * @param Iluni\BookBundle\Entity\Alumni $alumni
     * @return AAddress
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
}