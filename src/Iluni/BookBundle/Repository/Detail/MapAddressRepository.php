<?php

namespace Iluni\BookBundle\Repository\Detail;

use Iluni\BookBundle\Repository\CommonConstraintRepository;

/**
 * MAddressRepository
 *
 */
class MapAddressRepository extends CommonConstraintRepository
{
    protected static $order_by_choices = array(
        6  => 'r.id',
        26 => 'a.name',
        27 => 'o.name',
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
            ->select('r, m, a, o, ac')
            ->leftJoin('r.alumni_org_map', 'm')
            ->leftJoin('m.alumni', 'a')
            ->leftJoin('a.acommunities', 'ac')
            ->leftJoin('m.organization', 'o');

        $this->checkConstraintOrderBy($constraint);
        $this->checkConstraintCommunity($constraint);

        return $this->qb->getQuery();
    }
}

