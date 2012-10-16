<?php

namespace Iluni\BookBundle\Repository;

use Doctrine\ORM\EntityManager;

/**
 * SummaryRepository
 *
 * This is a non-entity repository.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class SummaryRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entityManager = $entity_manager;
    }

    private function translateResult($queryBuilder)
    {
        $query = $queryBuilder->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        return $query->getResult();
    }

    public function findTotalCommunity()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('c.id, c.name, count(ac) as total')
            ->from('IluniBookBundle:Community', 'c')
            ->leftJoin('c.acommunities', 'ac')
            ->where('c.typeId = 1')
            ->groupBy('c.id')
            ->orderBy('c.id')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    public function findTotalDepartment()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('d.id, d.name, count(ac) as total')
            ->from('IluniBookBundle:Category\Department', 'd')
            ->leftJoin('d.community', 'c')
            ->leftJoin('c.acommunities', 'ac')
            ->where('c.typeId = 1')
            ->groupBy('d.id')
            ->orderBy('d.id')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    public function findTotalFaculty()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('f.id, f.name, count(ac) as total')
            ->from('IluniBookBundle:Category\Faculty', 'f')
            ->leftJoin('f.community', 'c')
            ->leftJoin('c.acommunities', 'ac')
            ->where('c.typeId = 1')
            ->groupBy('f.id')
            ->orderBy('f.id')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    public function findTotalProgram()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('p.id, p.name, count(ac) as total')
            ->from('IluniBookBundle:Category\Program', 'p')
            ->leftJoin('p.community', 'c')
            ->leftJoin('c.acommunities', 'ac')
            ->where('c.typeId = 1')
            ->groupBy('p.id')
            ->orderBy('p.id')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    public function findTotalClassofYear()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('ac.id, ac.classYear, ac.name, count(ac) as total')
            ->from('IluniBookBundle:Detail\AlumniCommunities', 'ac')
            ->leftJoin('ac.community', 'c')
            ->where('c.typeId = 1')
            ->groupBy('ac.classYear')
            ->orderBy('ac.classYear')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    public function findTotalAlumniCommunities()
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('ac.name, ac.classYear, c.id, count(ac) as total')
            ->from('IluniBookBundle:Detail\AlumniCommunities', 'ac')
            ->leftJoin('ac.community', 'c')
            ->where('c.typeId = 1')
            ->groupBy('ac.classYear, c.id')
            ->orderBy('ac.classYear, c.id')
            ->having('total > 0');

        return $this->translateResult($qb);
    }

    private function getTotalQuery()
    {
        $lang = $this->getUser()->getCulture();

        switch ($this->group_by) {
            case 1: // Community
                break;
            case 2: // Department
                break;
            case 3: // Faculty
                break;
            case 4: // Program
                break;
            case 5: // Class of Year
                $query = Doctrine_Core::getTable('ACommunities')
                    ->createQuery('ac')
                    ->select('COUNT(ac.aid) AS total, '.
                        'c.cid, ac.class_year')
                    ->leftJoin('ac.Community c')
                    ->groupBy('ac.class_year')
                    ->orderBy('ac.class_year');
                break;
            case 6: // Community
                $query = Doctrine_Core::getTable('ACommunities')
                    ->createQuery('ac')
                    ->select('COUNT(ac.aid) AS total, '.
                        'c.cid, ac.class_year, ac.community')
                    ->leftJoin('ac.Community c')
                    ->groupBy('c.cid, ac.class_year')
                    ->orderBy('c.cid, ac.class_year');
                break;
        }  // switch

        return $query;
    }
}

