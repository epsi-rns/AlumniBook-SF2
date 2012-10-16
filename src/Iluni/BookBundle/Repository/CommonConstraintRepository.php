<?php

namespace Iluni\BookBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommonConstraintRepository
 *
 * This is a common base class for detail repository
 * containing miscellanous helpers used to build filter constraint.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class CommonConstraintRepository extends EntityRepository
{
    protected $qb;

    protected function checkConstraintOrderBy($constraint = array())
    {
        if (isset($constraint['orderBy'])) {
            $orderBy = $constraint['orderBy'];
            $orderByExist = array_key_exists($orderBy, static::$order_by_choices);

            if ($orderByExist) {
                $statement = static::$order_by_choices[$orderBy];
                $this->qb->orderBy($statement);
            }
        }
    }

    protected function checkConstraintCommunity($constraint = array())
    {
        if (isset($constraint['community'])) {
            extract($constraint['community']);

            if (!empty($program)) {
                $this->qb
                    ->andWhere('ac.program = :program_id')
                    ->setParameter('program_id', $program);
            }

            if (!empty($department)) {
                $this->qb
                    ->andWhere('ac.department = :department_id')
                    ->setParameter('department_id', $department);
            }

            if (!empty($faculty)) {
                $this->qb
                    ->andWhere('ac.faculty = :faculty_id')
                    ->setParameter('faculty_id', $faculty);
            }

            if (!empty($classYear)) {
                $this->checkConstraintClassYear($classYear);
            }

            if (!empty($decade)) {
                $this->checkConstraintDecade($decade);
            }
        }
    }

    protected function checkConstraintClassYear($value)
    {
        $this->qb
            ->andWhere('ac.classYear = :class_year')
            ->setParameter('class_year', $value);
    }

    protected function checkConstraintDecade($value)
    {
        $decades = array(1960, 1970, 1980, 1990, 2000, 2010);
        if (in_array($value, $decades)) {
            $this->qb
                ->andWhere('ac.classYear >= :decade_floor')
                ->setParameter('decade_floor', $value);

            $this->qb
                ->andWhere('ac.classYear <= :decade_ceiling')
                ->setParameter('decade_ceiling', $value+9);
        }
    }

    protected function checkConstraintContactType($constraint = array())
    {
        if (isset($constraint['contactType'])) {
            $this->qb
                ->where('ct.id = :contact_type_id')
                ->setParameter('contact_type_id', $constraint['contactType']);
        }
    }
}

