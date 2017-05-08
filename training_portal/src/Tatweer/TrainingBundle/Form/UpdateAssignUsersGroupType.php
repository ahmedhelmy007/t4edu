<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class UpdateAssignUsersGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //$listener = new UpdateAssignUsersGroupDataListener($builder->getFormFactory());
        //$builder->addEventSubscriber($listener);
        
//$roles = ['role1', 'role2', 'role3'];
        $builder
               // ->add('group')
                
               /* ->add('roleIds','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Roles',
                'property' => 'nameEn',
                'multiple' => true,
                'expanded' => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Roles')->where('Roles.idRole IN (2,4)');} ))
               */
                ->add('role','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Roles',
                'property' => 'nameEn',
               //  'multiple' => true,
                 'expanded' => true,
                'query_builder'=>function(EntityRepository $er) use ( $options )  {
               return $er->createQueryBuilder('Roles')->where('Roles.idRole IN ('.  implode(',', $options['search_roles']).')');} ))
                 /*      ->add('roles', 'choice', [
            'choices' => $roles,
            'multiple' => true,
            'expanded' => true
        ])

             /*->add('groupId','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Groups',
                'property' => 'group',
                'multiple' => true,
                'expanded' => true,
                'query_builder'=>function(EntityRepository $er) {
               return $er->createQueryBuilder('Groups')->where('Groups.idGroup = 70');} ))*/
                       
            
 

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Permissions' ,
            'search_roles' => FALSE ,
         

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_permissions';
    }
}
