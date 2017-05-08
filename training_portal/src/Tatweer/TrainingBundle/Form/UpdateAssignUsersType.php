<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class UpdateAssignUsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if( $options["locale"] == 'ar' ) $entity_name= 'nameAr'; else $entity_name= 'nameEn';
        if($options["is_department"]) $roles_arr = array(2,4); else $roles_arr = array(3,5);
        $builder
            ->add('employeeGrade')
                ->add('roleIds','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Roles',
                'property' => $entity_name,
                'multiple' => true,
                'expanded' => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Roles')->where('Roles.idRole IN (2,4)');} ))
               
               
           /* ->add('roleUserGroup', 'collection', array(
                'type' => 'entity',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'options' => array(
                    'multiple' => true,
                    'class' => 'TatweerTrainingBundle:Roles',
                    'property' => 'nameEn'
                    )
            ))*/
                
           /* ->add('roleUserGroup', 'collection', array(
                    'type' => new UpdateAssignUsersGroupType(),
                    'options'  => array(
                    'search_roles' => $roles_arr,
                        ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    ))
                */
                
                
            /*->add('roleIds','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Roles',
                'property' => $entity_name,
                'multiple' => true,
                'expanded' => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Roles')->where('Roles.idRole IN (2,4)');} ))
            /*->add('usergroups','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Groups',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Groups')->where('Groups.idGroup IN (70)');} ))*/
               
               //->add('groupId', null, array('mapped' => false))
           /* ->add('groupId','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Groups',
                "multiple" => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Groups')->where('Groups.idGroup = 70');} ))*/
              // ->add('groupId', 'collection' , array('data_class' => 'Tatweer\TrainingBundle\Entity\Groups' ))
              /*  ->add('groupId', 'collection' , array(
                    'type' => new UpdateAssignUsersGroupType(),
                                        'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                    // options on the rendered TagTypes
                    ),
                ))
               
               
            /*->add('nameAr','entity', array(
                'class'=>   'Tatweer\TrainingBundle\Entity\Roles',
                'property'=>'nameAr')
                    )*/
           // ->add('role2')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Users' ,
            'locale' => 'en' ,
            'is_department' => FALSE,

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_users';
    }
}
