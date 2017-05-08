<?php

namespace Tatweer\TrainingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class TrainingsType extends AbstractType
{
    protected $translator;
    protected $em;
    
    public function __construct($translator= null , $em = null){

      $this->translator = $translator;
      $this->em = $em;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $trainingNeedId = $options["trainingNeedId"];
        
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
            
           /* ->add('trainingNeedsProgram', 'choice', array(
                'label' =>  $this->translator->trans('Training program' , array() , 'trainingdetails') ,
                  'choices'   => $this->getTrainingNeedsPrograms($options["trainingNeedId"] , $options["locale"]),
                ))*/
            ->add('trainingNeedsProgram','entity', array(
                'label' =>  $this->translator->trans('Training needs program' , array() , 'trainingdetails'),
                'class'    => 'Tatweer\TrainingBundle\Entity\TrainingNeedsValues',
                'property' => $trainingNeedSelection,
                'multiple' => false,
                'expanded' => false,
                'query_builder' =>function(EntityRepository $er ) use($trainingNeedId)  {
               return $er->createQueryBuilder('TrainingNeedsValues')
                      ->where("TrainingNeedsValues.trainingNeed = :id_need AND TrainingNeedsValues.section IN ('suggested trainings by HR','additional trainings')")
                      ->setParameter('id_need' , $trainingNeedId)
                       ;} ,

                       
                       ))
               
               
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
            /*->add('language', 'choice', array(
                'label' =>  $this->translator->trans('Language' , array() , 'trainingdetails') ,
                  'choices'   => $this->getLanguages($options["locale"]),
                ))*/
                               
            ->add('language','entity', array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Languages',
                'label' =>  $this->translator->trans('Language' , array() , 'trainingdetails'),
                'property' => $languageSelection,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function(EntityRepository $er ) {
               return $er->createQueryBuilder('Languages')
                       ;} ))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tatweer\TrainingBundle\Entity\Trainings',
            'locale'=>       'en',
            'trainingNeedId' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tatweer_trainingbundle_trainings';
    }
    
    
    private function getLanguages($locale)
    {
        $langlist = array();
     
        $languages = $this->em
            ->getRepository('Tatweer\TrainingBundle\Entity\Languages')
            ->createQueryBuilder('lg')
            ->getQuery()
            ->getResult();
        
        $langlist[0] = $this->translator->trans('Select');
       // print_r($languages);
        foreach ($languages as $language) {
       
           IF($locale == 'ar')
            $langlist[$language->getIdLanguage()] = $language->getNameAr();
            else
            $langlist[$language->getIdLanguage()] = $language->getNameEn();
        }
        
        $langlist[-1] = $this->translator->trans('Other' , array() , 'trainingdetails');
         

        return $langlist;
    }
    
    private function getTrainingNeedsPrograms($trainingNeedId , $locale)
    {
        $datalist = array();
     
        $results = $this->em
            ->getRepository('Tatweer\TrainingBundle\Entity\TrainingNeedsValues')
            ->createQueryBuilder('t')
                ->where ("t.trainingNeed = :id_need AND t.section IN ('suggested trainings by HR','additional trainings')")
                ->setParameter('id_need' , $trainingNeedId)
            ->getQuery()
            ->getResult();
        
        $datalist[0] = $this->translator->trans('Select');
        
        foreach ($results as $result) {
            
            IF($locale == 'ar')
            $datalist[$result->getIdValue()] = $result->getValueAr();
            else
            $datalist[$result->getIdValue()] = $result->getValueEn();
        }
        
    
         

        return $datalist;
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
    
}
