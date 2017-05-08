<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluationPeriodsType extends AbstractType
{
    protected $translator;
    
    public function __construct($translator= null){

      $this->translator = $translator;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $activeOptions = array(1=> $this->translator->trans('Active') ,0=> $this->translator->trans('Inactive'));
        $builder
            ->add('name','text', 
                    array('label' => 'Period name', 'translation_domain' => 'periods'),
                    array('attr' => array('placeholder' => 'Name', 'title'=>'Name' ) ) )
            ->add('startDate', 'text', array('attr' => array('class'=>'date_picker' , 'readonly' => "readonly" ) ) )
            ->add('endDate', 'text', array('attr' => array('class'=>'date_picker future' , 'readonly' => "readonly" ) ) )
            ->add('active', 'choice',
                    array('label' => 'Status', 
                        'choices' => $activeOptions,
                        )
                    )
            ->add('reminderDate', 'text',
                array('label' => 'Reminder date', 'translation_domain' => 'periods', 'attr' => array('class'=>'date_picker') ) )
            ->add('trainingNeedsStartDate', 'text',
                array('label' => 'Training needs start date', 'translation_domain' => 'periods', 'attr' => array('class'=>'date_picker') ) )
            ->add('trainingNeedsEndDate', 'text',
                array('label' => 'Training needs end date', 'translation_domain' => 'periods', 'attr' => array('class'=>'date_picker') ) )
            ->add('trainingNeedsActive')
            ->add('trainingNeedsReminderDate', 'text',
                array('label' => 'Reminder date', 'translation_domain' => 'periods', 'attr' => array('class'=>'date_picker') ) )
            ->add('trainingNeedsActive', 'choice',
                    array('label' => 'Status', 
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
            'data_class' => 'Tatweer\TrainingBundle\Entity\EvaluationPeriods'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_evaluationperiods';
    }
}
