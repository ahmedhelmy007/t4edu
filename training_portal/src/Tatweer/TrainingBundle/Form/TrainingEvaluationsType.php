<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingEvaluationsType extends AbstractType
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
      
        $builder
         //   ->add('traineeComment' , 'textarea', array('label' => $this->translator->trans('Comment' , array() , 'trainingevaluation'))  )
           // ->add('trainee', 'text', array(
           // 'label' => 'Field',
           // 'data' => 'Default value'
           //  ))
           // ->add('training')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\TrainingEvaluations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_trainingevaluations';
    }
}
