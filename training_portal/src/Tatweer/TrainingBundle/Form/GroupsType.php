<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class GroupsType extends AbstractType
{
    //private $group_id; // type if department of group 
   
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
        $data = $builder->getData();
       // $this->group_id = $data->getidGroup();
        
      //  if($this->group_id)
       // {
        $builder
            ->add('name' ,'text' , array('label' =>  $this->translator->trans('Name' , array() , 'groups'), 'required' => 'required' , 'max_length' => 40) )
            ->add('description', 'textarea' , array('label' => $this->translator->trans('Description' , array() , 'groups')  , 'max_length' => 200 ) )
            //->add('parent', 'hidden', array('data' => $this->parent_id ))
   
        ;
       /*
        * 
               /* ->add('parent','entity', array(
                'class'=>   'Tatweer\TrainingBundle\Entity\Groups',
                'property'=>'name',
                'query_builder'=>function(EntityRepository $er ) {
               return $er->createQueryBuilder('Groups')->where('Groups.parent IS NULL OR Groups.idGroup <> '.$this->group_id) ;} ))
        * 
        *  }
        else 
        {
        $builder
            ->add('name')
            ->add('description')
            ->add('parent')
            ->add('parent','entity', array(
                'class'=>   'Tatweer\TrainingBundle\Entity\Groups',
                'property'=>'name',
                'query_builder'=>function(EntityRepository $er ) {
               return $er->createQueryBuilder('Groups')->where('Groups.parent IS NULL ') ;} ))
        ;
        }*/
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Groups'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_groups';
    }
    

}
