<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DepartmentsType extends AbstractType
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
            ->add('name' ,'text' , array('label' =>  $this->translator->trans('Name' , array() , 'departments') , 'required' => 'required' , 'max_length' => 40 ))
            ->add('description' , 'textarea' , array('label' => $this->translator->trans('Description' , array() , 'departments')  , 'max_length' => 200  ))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Departments'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_departments';
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $results
     */
    public function buildAssignForm(FormBuilderInterface $builder, array $results)
    {
        $builder
            ->add('name')
            ->add('description')
            
        ;
    }
}
