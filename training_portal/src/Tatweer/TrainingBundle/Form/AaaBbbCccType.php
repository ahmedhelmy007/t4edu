<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AaaBbbCccType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('cccCcc','entity', array('class'=>'Tatweer\TrainingBundle\Entity\CccCcc', 'property'=>'name' ))
                
            ->add('aaaAaa','entity', array('class'=>'Tatweer\TrainingBundle\Entity\AaaAaa', 'property'=>'name' ))
            ->add('bbbBbb','entity', array('class'=>'Tatweer\TrainingBundle\Entity\BbbBbb', 'property'=>'name' ))
            ->add('value')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\AaaBbbCcc'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_departments';
    }
}
