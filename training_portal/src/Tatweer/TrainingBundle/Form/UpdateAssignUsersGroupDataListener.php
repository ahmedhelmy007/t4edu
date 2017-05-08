<?php

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateAssignUsersGroupDataListener implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {  
        $this->factory = $factory;
    }  

    public static function getSubscribedEvents()
    {  
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        ); 
    }  

    public function preSetData(DataEvent $event)
    {  
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data)
            return;

        if (!$form->has('value')) {
            // $data is your setting, do whatever conditionnal form creation
               // you want using it here !

            if ($data->getType() == "boolean") {
                $form->add($this->factory->createNamed('text', 'value'));
            } else {
                $form->add($this->factory->createNamed('checkbox', 'value'));
            }  
                }
    }  
}