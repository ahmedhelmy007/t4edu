<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class IndividualTrainingsType extends AbstractType
{
    protected $translator;
    protected $em;
    
    public function __construct($translator= null , $em = null , $id = null ){

      $this->translator = $translator;
      $this->em = $em;
      $this->id = $id;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
 
        if($options["locale"] == 'ar') 
        {
            $trainingNeedSelection = 'valueAr'; 
            $languageSelection = 'nameAr'; 
  
        }
        else 
        {
            $trainingNeedSelection = 'valueEn'; 
            $languageSelection = 'nameEn'; 
         
        }
        
        $builder
            ->add('name' , 'text' , array('label' =>  $this->translator->trans('Course name' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 200) ))
            ->add('providerName' , 'textarea' , array('label' =>  $this->translator->trans('Provider' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 250) ))
            ->add('startDate', 'text', array('label' =>  $this->translator->trans('Start date' , array() , 'trainingdetails') , 'attr' => array('class'=>'date_picker future startdate readonly' , 'required' => 'required' )))
            ->add('endDate', 'text', array('label' =>  $this->translator->trans('End date' , array() , 'trainingdetails') , 'attr' => array('class'=>'date_picker future enddate readonly' , 'required' => 'required'  ) ))
            ->add('duration' , 'text' , array('label' =>  $this->translator->trans('Duration' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 10 , 'class'=> 'numbersOnly' ) ))
            ->add('country', 'choice', array(
                'label' =>  $this->translator->trans('Country' , array() , 'trainingdetails') ,
                  'choices'   => $this->getCountries($options["locale"]),
                ))
            
                               
            ->add('city', 'text' , array('label' =>  $this->translator->trans('City' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 100 , 'class' => 'isArabicAndEnglishletters') ))
                               
            ->add('language','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Languages',
                'label' =>  $this->translator->trans('Language' , array() , 'trainingdetails'),
                'property' => $languageSelection,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function(EntityRepository $er ) {
               return $er->createQueryBuilder('Languages')
                       ;} ))
                       
            ->add('relatedTasks', 'textarea' , array('label' =>  $this->translator->trans('Related Tasks' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 300 , 'class' => 'isArabicAndEnglishletters' , 'required' => 'required' ) ))
              
            
        ;
                       
        
        if($this->getOtherLanguage())
        {
        $builder
            ->add('languageOther' , 'text' , array('label' =>  $this->translator->trans('Other language' , array() , 'trainingdetails') , 'attr' => array('maxlength' => 100) ))
        ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Trainings',
            'locale'=>       'en',
      
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_trainings';
    }
    
    
    private function getCountries($locale)
    {
        $langlist = array();
     
        $Countries = $this->em
            ->getRepository('Tatweer\TrainingBundle\Entity\Countries')
            ->createQueryBuilder('q')
            ->getQuery()
            ->getResult();
        
       // $langlist[0] = $this->translator->trans('Select');
        
        foreach ($Countries as $Country) {
            
            IF($locale == 'ar')
            $langlist[$Country->getId()] = $Country->getNameAr();
            else
            $langlist[$Country->getId()] = $Country->getNameEn();
        }
        
  

        return $langlist;
    }
    private function getOtherLanguage()
    {
       if($this->id)
       {
     
        $data = $this->em
            ->getRepository('Tatweer\TrainingBundle\Entity\Trainings')
            ->createQueryBuilder('q')
            ->where('q.idTraining = :id ')->setParameter('id' , $this->id )
            ->getQuery()
            ->getResult();
            
            IF($data[0]->getLanguageOther())
            return true;
       
       }
  

        return false;
    }
    
}
