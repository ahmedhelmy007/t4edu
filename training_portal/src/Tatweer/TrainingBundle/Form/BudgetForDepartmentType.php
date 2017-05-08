<?php

namespace Tatweer\TrainingBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;


class BudgetForDepartmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          //  ->add('name','text', array('attr' => array('placeholder' => 'name','title'=>'name')))
            ->add('budgetDepartments', 'collection', array(
                    'type' => new DepartmentBudgetType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => 'DepartmentBudgets__originalValue__',
                    'by_reference' => false,
                    
                    )) 
                

                
        //$subscriber = new AddNameFieldSubscriber($builder->getFormFactory());
       /* $builder
            ->add('name','text', array('attr' => array('placeholder' => 'name','title'=>'name')))
            ->add('budgetDepartments', 'collection', array(
                    'type' => new DepartmentBudgetType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => 'DepartmentBudgets__originalValue__',
                    'by_reference' => false,
                    
                    ))*/
//            ->add('originalValue', 'text')
//            ->add('budget')
//            ->add('department')
        ;
        //$builder->addEventSubscriber($subscriber);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Budgets'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_departmentbudgettype';
    }
}


class AddNameFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

//        print_r(sizeof($data->get()));
       
    }
}