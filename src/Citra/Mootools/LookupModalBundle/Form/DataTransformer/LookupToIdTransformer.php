<?php
namespace Citra\Mootools\LookupModalBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManager;

/**
 * This transform an entity into two field, it is (1) id and (2) name.
 * While id is rendered as hidden, name is rendered as readonly text
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LookupToIdTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $em;
    private $class;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->class = $class;
    }

    /**
     * Transforms an object (lookup) to an array (id, name).
     *
     * @param  Lookup|null $lookup
     * @return array
     */
    public function transform($lookup)
    {

        if (null === $lookup) {
            return array(
                'id'    => null,
                'name'  => null,
            );
        }

        return array(
            'id'    => $lookup->getId(),
            'name'  => $lookup->getName(),
        );
    }

    /**
     * Transforms an array (id, name) to an object (lookup).
     *
     * @param  array $params
     * @return Lookup|null
     * @throws TransformationFailedException if object (lookup) is not found.
     */
    public function reverseTransform($params)
    {
        if (empty($params)) {
            return null;
        }

        $id = $params['id'];

        if (!$id) {
            return null;
        }

        $lookup = $this->em
            ->getRepository($this->class)
            ->find($id);
        ;

        if (null === $lookup) {
            throw new TransformationFailedException(sprintf(
                'A lookup entity with id "%s" does not exist!',
                $id
            ));
        }

        return $lookup;
    }
}

