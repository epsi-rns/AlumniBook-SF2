<?php
namespace Iluni\BookBundle\Form\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Field type that handle translatable choice.
 * Using another approach display translatable entity.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class TranslatableChoiceType extends AbstractType
{
    protected $entityManager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entityManager = $entity_manager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $closure = function (Options $options) {
            return $options['class'] ? $this->buildChoices($options) : null;
        };

        $resolver->setDefaults(array(
            'choices'     => $closure,
            'required'    => false,
            'empty_value' => '----------',
            'empty_data'  => null,
            // custom properties
            'class' => null,
            'query_key'   => 'id',
            'query_value' => 'name',
            'query_find'  => null
        ));
    }

    private function buildChoices(Options $options)
    {
        $choices = array();
        $method_key = 'get'.ucfirst($options['query_key']);
        $method_value = 'get'.ucfirst($options['query_value']);

        $entities = $this->findEntities($options);

        foreach ($entities as $entity) {
            $choices[$entity->$method_key()] = $entity->$method_value();
        }

        return $choices;
    }

    private function findEntities(Options $options)
    {
        $em= $this->entityManager;
        $qb = $em->createQueryBuilder();

        // if empty 'class' you better throw something
        $qb->select('r')
           ->from($options['class'], 'r')
           ->orderBy('r.id');

        $id = $options['query_find'];
        if ($id) {
            $qb->where('r.id = :id')->setParameter('id', $id);
        }

        $query = $qb->getQuery();
        $query->setHint(

            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        return $query->getResult();
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'translatable_choice';
    }
}

