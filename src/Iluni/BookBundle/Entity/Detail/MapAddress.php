<?php

namespace Iluni\BookBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;
use Iluni\BookBundle\Entity\Base\Address;

/**
 * Iluni\BookBundle\Entity\Detail\MapAddress
 */
class MapAddress extends Address
{

    /**
     * @var Iluni\BookBundle\Entity\Detail\AlumniOrgMap
     */
    private $alumni_org_map;


    /**
     * Set alumni_org_map
     *
     * @param Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap
     * @return MapAddress
     */
    public function setAlumniOrgMap(\Iluni\BookBundle\Entity\Detail\AlumniOrgMap $alumniOrgMap = null)
    {
        $this->alumni_org_map = $alumniOrgMap;

        return $this;
    }

    /**
     * Get alumni_org_map
     *
     * @return Iluni\BookBundle\Entity\Detail\AlumniOrgMap
     */
    public function getAlumniOrgMap()
    {
        return $this->alumni_org_map;
    }
}

