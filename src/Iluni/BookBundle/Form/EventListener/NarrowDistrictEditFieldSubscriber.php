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
class NarrowDistrictEditFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SET_DATA => 'preSetData');
    }

    public function preSetData(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // Important!
        if (null === $data) {
            return;
        }

        $master_index = 0;
        $province = $data->getProvince();
        if (!empty($province)) {
            $master_index = $province->getId();
        }

        $form->add($this->factory->createNamed(
            'district',
            'partial_district_choice',
            null,
            array('master_index' => 13)
        ));
    }
}

