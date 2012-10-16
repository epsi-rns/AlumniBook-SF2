<?php
namespace Iluni\BookBundle\Form\ChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Doctrine\ORM\EntityManager;

use Iluni\BookBundle\Form\ChoiceList\PartialEntityLoader;

/**
 * Field type that handle partial choice (ajax).
 * Using gedmo approach display translatable entity.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class PartialChoiceType extends AbstractType
{
    protected $entityManager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entityManager = $entity_manager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $type = $this;

        // override with new closure
        $choice_list = function (Options $options) use ($type) {
            return ($options['class'] and $options['master_name'])
                    ? $type->getChoiceList($options)
                    : null;
        };

        $message_closure = function (Options $options) {
            // check master_key index
            return empty($options['master_index'])
                ? $options['empty_message1']
                : $options['empty_message2'];
        };

        $resolver->setDefaults(array(
            // override parent (translatable_choice) properties
            'choice_list'     => $choice_list,
            // replaced properties
            'empty_value' => $message_closure,
            'empty_message1' => '-- please select master first --',
            'empty_message2' => '-- all details in this master --',
            // required properties
            'master_name' => null,
            'master_index' => 0
        ));
    }

    protected function getEntityLoader(Options $options)
    {
        return new PartialEntityLoader(
            $this->entityManager,
            $options['class'],
            $options
        );
    }

    protected function getChoiceList(Options $options)
    {
        $loader = $this->getEntityLoader($options);

        return new EntityChoiceList(
            $this->entityManager,
            $options['class'],
            null,
            $loader
        );
    }

    public function getParent()
    {
        return 'translatable_choice';
    }

    public function getName()
    {
        return 'partial_choice';
    }
}

