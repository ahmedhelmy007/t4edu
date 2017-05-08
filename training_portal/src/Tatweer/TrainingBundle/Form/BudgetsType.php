<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BudgetsType extends AbstractType
{
    
    protected $translator;
 
    
    public function __construct($translator= null ){

      $this->translator = $translator;
 
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                $activeOptions = array('' => $this->translator->trans('Select') , 1 => $this->translator->trans('Active', array() , 'trainingexpensesclasses') ,0 => $this->translator->trans('Inactive', array() , 'trainingexpensesclasses'));

        $builder
            ->add('name' , 'text' , array('label' =>  $this->translator->trans('Name' , array() , 'budgets') , 'attr' => array('maxlength' => 80, 'required' => 'required' ) ))
            ->add('startDate', 'text', array('label' =>  $this->translator->trans('Start date' , array() , 'budgets') , 'attr' => array('class'=>'date_picker  startdate readonly' , 'required' => 'required' )))
            ->add('endDate', 'text', array('label' =>  $this->translator->trans('End date' , array() , 'budgets') , 'attr' => array('class'=>'date_picker  enddate readonly' , 'required' => 'required'  ) ))

                ->add('active', 'choice',
                    array('label' => $this->translator->trans('Status' , array() , 'budgets') , 
                        'required' => 'required' , 
                        'choices' => $activeOptions,
                        )
                    )
        ;
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
        return 'tatweer_trainingbundle_budgets';
    }
}
