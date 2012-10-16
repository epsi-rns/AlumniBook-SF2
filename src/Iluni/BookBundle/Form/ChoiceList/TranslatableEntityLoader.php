<?php
namespace Iluni\BookBundle\Form\ChoiceList;

use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * Entity loader for used in translatable choice.
 *
 * It is basically just a form builder workaround
 * to display gedmo translatable entity.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class TranslatableEntityLoader implements EntityLoaderInterface
{
    private $alias;
    private $parameter;

    protected $entityManager;
    protected $classData;
    protected $options;


    public function __construct(EntityManager $entityManager, $classData, $options)
    {
        $this->entityManager = $entityManager;
        $this->classData = $classData;
        $this->options = $options;

        $this->alias = 'r';
        $this->parameter = 'ids';
    }

    protected function getAlias()
    {
        return $this->alias;
    }

    protected function getBasicQueryBuilder()
    {
        $em = $this->entityManager;
        return $em->createQueryBuilder()
            ->select($this->alias)
            ->from($this->classData, $this->alias)
            ->orderBy($this->alias.'.id');
    }

    protected function getExtendedQueryBuilder($qb)
    {
        $find = $this->options['query_find'];
        if ($find) {
            $qb
                ->where('r.id = :find_id')
                ->setParameter('find_id', $find);
        }

        return $qb;
    }

    protected function getQuery($qb)
    {
        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query;
    }

    public function getEntities()
    {
        $qb = $this->getBasicQueryBuilder();
        $qb = $this->getExtendedQueryBuilder($qb);

        return $this->getQuery($qb)->getResult();
    }


    public function getEntitiesByIds($identifier, array $values)
    {
        $qb = $this->getBasicQueryBuilder();
        $qb = $this->getExtendedQueryBuilder($qb);

        $where = $qb
            ->expr()
            ->in($this->alias.'.'.$identifier, ':'.$this->parameter);

        $qb
            ->andWhere($where)
            ->setParameter($this->parameter, $values, Connection::PARAM_INT_ARRAY);

        return $this->getQuery($qb)->getResult();
    }
}

