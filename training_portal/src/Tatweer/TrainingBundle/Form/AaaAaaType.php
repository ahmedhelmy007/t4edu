<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AaaAaaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('aaaBbbCccCollection')
//            ->add('aaaBbbCccCollection', 'collection', array(
//                'type' => new AaaBbbCccType(),
//                'allow_add' => true,
//                'allow_delete' => true,
//                'prototype' => true,
//                'prototype_name' => 'AaaBbbCcc__value__',
//                'options' => array(
//                // options on the rendered TagTypes
//                ),
//            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\AaaAaa'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_aaaaaatype';
        
    }
}
