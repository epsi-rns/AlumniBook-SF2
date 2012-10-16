<?php
namespace Iluni\BookBundle\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

/**
 * FieldSubscriber to initiate detail table values before ajax call
 * and is used with partial choice in dropdown controller
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class NarrowDepartmentFilterFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_BIND => 'preBind');
    }

    public function preBind(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // Important!
        if (null === $data) {
            return;
        }

        $master_index = 0;
        if (is_array($data) and isset($data['faculty'])) {
            $master_index = $data['faculty'];
        }

        $form->add($this->factory->createNamed(
            'department',
            'partial_department_choice',
            null,
            array('master_index' => $master_index)
        ));

    }
}

