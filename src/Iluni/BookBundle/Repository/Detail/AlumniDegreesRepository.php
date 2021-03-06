<?php

namespace Iluni\BookBundle\Repository\Detail;

use Iluni\BookBundle\Repository\CommonConstraintRepository;

/**
 * ADegreesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlumniDegreesRepository extends CommonConstraintRepository
{
    protected static $order_by_choices = array(
        1  => 'r.id',
        21 => 'a.name',
        101 => 'ac.community, a.name',
        102 => 'ac.department, ac.program, ac.classYear, a.name',
        103 => 'ac.faculty, ac.department, ac.program, ac.classYear, a.name',
        104 => 'ac.program, ac.department, ac.classYear, a.name',
        105 => 'ac.classYear, ac.department, a.name'    // default
    );

    public function findQueryFilter($constraint = array())
    {
        $this->qb = $this->createQueryBuilder('r')
            ->select('r, a, s, ac')
            ->leftJoin('r.alumni', 'a')
            ->leftJoin('r.strata', 's')
            ->leftJoin('a.acommunities', 'ac');

        $this->checkConstraintOrderBy($constraint);
        $this->checkConstraintCommunity($constraint);

        return $this->qb->getQuery();
    }

    public function findList($aid)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r, s')
            ->leftJoin('r.alumni', 'a')
            ->leftJoin('r.strata', 's')
            ->where('a.id = :aid')
            ->setParameter('aid', $aid);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}

