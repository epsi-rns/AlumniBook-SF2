<?php
namespace Iluni\BookBundle\Form\ChoiceList;

use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * Entity loader for used in partial choice.
 *
 * It is basically just a form builder workaround
 * to display gedmo translatable entity.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class PartialEntityLoader extends TranslatableEntityLoader
{
    public function getEntities()
    {
        $index  = (int) $this->options['master_index'];

        if ($index) {
            return parent::getEntities();
        } else {
            return array();
        }
    }

    protected function getExtendedQueryBuilder($qb)
    {
        $qb = parent::getExtendedQueryBuilder($qb);

        if ($this->options['master_name']) {
            $name   = $this->options['master_name'];
            $index  = (int) $this->options['master_index'];
            $alias  = $this->getAlias();

            if ($index) {
                $qb
                    ->where($alias.'.'.$name.' = :id')
                    ->setParameter('id', $index);
            }
        }

        return $qb;
    }
}

