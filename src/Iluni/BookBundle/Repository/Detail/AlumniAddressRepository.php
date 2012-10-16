<?php

namespace Iluni\BookBundle\Repository\Detail;

use Iluni\BookBundle\Repository\CommonConstraintRepository;

/**
 * AAddressRepository
 *
 */
class AlumniAddressRepository extends CommonConstraintRepository
{
    protected static $order_by_choices = array(
        6  => 'r.id',
        21 => 'a.name',
        60 => 'r.address',
        61 => 'r.region',
        63 => 'r.country',
        64 => 'r.province',
        65 => 'r.district',
        66 => 'r.postal_code',
        67 => 'r.street',
        68 => 'r.area',
        69 => 'r.building'
    );

    public function findQueryFilter($constraint = array())
    {
        $this->qb = $this->createQueryBuilder('r')
            ->select('r, a, ac')
            ->leftJoin('r.alumni', 'a')
            ->leftJoin('a.acommunities', 'ac');

        $this->checkConstraintOrderBy($constraint);
        $this->checkConstraintCommunity($constraint);

        return $this->qb->getQuery();
    }
}

