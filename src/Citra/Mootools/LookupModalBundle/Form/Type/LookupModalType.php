<?php
namespace Citra\Mootools\LookupModalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

use Citra\Mootools\LookupModalBundle\Form\DataTransformer\LookupToIdTransformer;

/**
 * This transform an entity into two field, it is (1) id and (2) name.
 * While id is rendered as hidden, name is rendered as readonly text
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class LookupModalType extends AbstractType
{
    protected $entityManager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entityManager = $entity_manager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'class'
        ));

        $resolver->setDefaults(array(
            'invalid_message' => 'The selected lookup entity does not exist',
            'required' => false,
            'link_text'  => 'Pick',
            'link_route' => '',
            'link_title' => '',
            'link_style' => 'icon_pick',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new LookupToIdTransformer(
            $this->entityManager,
            $options['class']
        );

        $builder
            ->add('id', 'hidden')
            ->add('name', 'text', array('read_only' => true))
            ->addViewTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'link_route' => $options['link_route'],
            'link_style' => $options['link_style'],
            'link_text'  => $options['link_text'],
            'link_title' => $options['link_title'],
        ));
    }

    public function getParent()
    {
        return 'field';
    }

    public function getName()
    {
        return 'lookupmodal';
    }
}

