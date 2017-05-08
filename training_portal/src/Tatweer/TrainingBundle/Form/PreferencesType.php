<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreferencesType extends AbstractType
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
        $builder
            ->add('evaluationDuration' , 'text' , array('label' =>  $this->translator->trans('Evaluation duration (months)' , array() , 'preferences') , 'attr' => array('class'=>'numbersOnly' , 'required' => 'required' ,'maxlength' => 11) ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Preferences'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_preferences';
    }
}
