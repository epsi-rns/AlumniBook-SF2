<?php

namespace Iluni\BookBundle\Repository\Detail;

use Iluni\BookBundle\Repository\CommonConstraintRepository;

/**
 * OAddressRepository
 *
 */
class OrgAddressRepository extends CommonConstraintRepository
{
    protected static $order_by_choices = array(
        6  => 'r.id',
        23 => 'o.name',
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
            ->select('r, o')
            ->leftJoin('r.organization', 'o');

        $this->checkConstraintOrderBy($constraint);

        return $this->qb->getQuery();
    }
}

