<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\TrainingEvaluations;
use Tatweer\TrainingBundle\Form\TrainingEvaluationsType;
use Tatweer\TrainingBundle\Entity\TrainingEvaluationValues;
/**
 * TrainingEvaluations controller.
 *
 * @Route("/trainingevaluations")
 */
class TrainingEvaluationsController extends Controller
{

    /**
     * Lists all TrainingEvaluations entities.
     *
     * @Route("/", name="trainingevaluations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->getApprovedTrainings();
        
        return array(
            'entities' => $entities,
            'pageSubTitle' => $this->get('translator')->trans('Training evaluation' , array() , 'navbar')
        );
    }
    /**
     * Creates a new TrainingEvaluations entity.
     *
     * @Route("/{training_id}", name="trainingevaluations_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:TrainingEvaluations:new.html.twig")
     */
    public function createAction(Request $request , $training_id)
    {
        $entity = new TrainingEvaluations();
        $em = $this->getDoctrine()->getManager();
        $CurrentLoggedInUserId     = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $CreatedByObj              = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $trainingObj               = $em->getRepository('TatweerTrainingBundle:Trainings')->find($training_id);
        
        
        $entity->setCreatedBy($CreatedByObj);
        $entity->setTrainee($CreatedByObj);
        $entity->setTraining($trainingObj);
        
        
        $form = $this->createCreateForm($entity , $training_id);
        $form->handleRequest($request);


        if ($form->isValid()) {
     
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trainingevaluations_show', array('id' => $entity->getIdEvaluation())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('TRAINING EVALUATION FORM' , array() , 'trainingevaluation')
        );
    }

    /**
     * Creates a form to create a TrainingEvaluations entity.
     *
     * @param TrainingEvaluations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TrainingEvaluations $entity , $training_id)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new TrainingEvaluationsType($translator), $entity, array(
            'action' => $this->generateUrl('trainingevaluations_create' , array('training_id' => $training_id) ),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new TrainingEvaluations entity.
     *
     * @Route("/{training_id}/new", name="trainingevaluations_new")
     * @Template()
     */
    public function newAction($training_id)
    {
        $entity = new TrainingEvaluations();
        $em = $this->getDoctrine()->getManager();
        
        // get course data
        $courseentity = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserTrainingById($training_id);
        $form = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->buildForm();

         if($trainingNeed = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingNeedByTraining($training_id))
         { 

            $userentity                      = $em->getRepository('TatweerTrainingBundle:Users')->find($trainingNeed->getRequestedForEmployee()->getIdUser());
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $userentity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $userentity->getEmployeeGrade();
            $userDataFromAD->idUser          = $trainingNeed->getRequestedForEmployee()->getIdUser();
         }

        if(isset($_POST['save_evaluation'])) 
        {
            
        $CurrentLoggedInUserId     = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $CreatedByObj              = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        $trainingObj               = $em->getRepository('TatweerTrainingBundle:Trainings')->find($training_id);
        
        
        $entity->setCreatedBy($CreatedByObj);
        $entity->setTrainee($CreatedByObj);
        $entity->setTraining($trainingObj);
        
        if($_POST['comment'])
        $entity->setTraineeComment($_POST['comment']);

        $em->persist($entity);
        $em->flush();
        
              
            // save evaluation values 
            foreach($_POST['e_values'] as $k => $v )
            { 
               $criteriaObj = $em->getRepository('TatweerTrainingBundle:TrainingEvaluationCriterias')->find($k);
               $optionObj = $em->getRepository('TatweerTrainingBundle:TrainingEvaluationOptions')->find($v);
                   // if insert new evaluation values
               $EmployeeEvaluationValue = new TrainingEvaluationValues(); 

               
               $EmployeeEvaluationValue->setCriteria($criteriaObj);
               $EmployeeEvaluationValue->setEvaluation($entity);
               $EmployeeEvaluationValue->setSelectedOption($optionObj);
               

               $em->persist($EmployeeEvaluationValue);
               
               $em->flush(); 

            }
            
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('trainingevaluations_show', array('id' => $entity->getIdEvaluation())));

        }
        
        return array(
            'entity'            => $entity,
            'form_sections'     => $form['sectionResult'],
            'form_criterias'    => $form['criteriasResult'],
            'form_options'      => $form['optionsResult'],
            'userentity'        => $userDataFromAD,
            'courseentity'      => $courseentity,
            'pageSubTitle' => $this->get('translator')->trans('TRAINING EVALUATION FORM' , array() , 'trainingevaluation')
        );
    }

    /**
     * Finds and displays a TrainingEvaluations entity.
     *
     * @Route("/{id}", name="trainingevaluations_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->find($id);
        // get course data
        $courseentity = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserTrainingById($entity->getTraining());
        $form = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->buildForm($id);

         if($trainingNeed = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingNeedByTraining($entity->getTraining()))
         { 

            $userentity                      = $em->getRepository('TatweerTrainingBundle:Users')->find($trainingNeed->getRequestedForEmployee()->getIdUser());
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $userentity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $userentity->getEmployeeGrade();
            $userDataFromAD->idUser          = $trainingNeed->getRequestedForEmployee()->getIdUser();
         }
         
        return array(
            'entity'            => $entity,
            'form_sections'     => $form['sectionResult'],
            'form_criterias'    => $form['criteriasResult'],
            'form_options'      => $form['optionsResult'],
            'userentity'        => $userDataFromAD,
            'courseentity'      => $courseentity,
            'pageSubTitle' => $this->get('translator')->trans('View details' , array() , 'messages')
        );
        

    }

    /**
     * Displays a form to edit an existing TrainingEvaluations entity.
     *
     * @Route("/{id}/edit", name="trainingevaluations_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingEvaluations entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a TrainingEvaluations entity.
    *
    * @param TrainingEvaluations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TrainingEvaluations $entity)
    {
        $form = $this->createForm(new TrainingEvaluationsType(), $entity, array(
            'action' => $this->generateUrl('trainingevaluations_update', array('id' => $entity->getIdEvaluation())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TrainingEvaluations entity.
     *
     * @Route("/{id}", name="trainingevaluations_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:TrainingEvaluations:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingEvaluations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('trainingevaluations_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TrainingEvaluations entity.
     *
     * @Route("/{id}", name="trainingevaluations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TrainingEvaluations entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trainingevaluations'));
    }

    /**
     * Creates a form to delete a TrainingEvaluations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trainingevaluations_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
     /**
     * export to pdf 
     *
     * @Route("/{id}/export", name="_export_trainingevaluation")
     * 
     * @Template("TatweerTrainingBundle:TrainingEvaluations:show.html.twig")
     */
    public function export(Request $request, $id )
    {

        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->find($id);
        // get course data
        $courseentity = $em->getRepository('TatweerTrainingBundle:Trainings')->getUserTrainingById($entity->getTraining());
        $form = $em->getRepository('TatweerTrainingBundle:TrainingEvaluations')->buildForm($id);

         if($trainingNeed = $em->getRepository('TatweerTrainingBundle:Trainings')->getTrainingNeedByTraining($entity->getTraining()))
         { 

            $userentity                      = $em->getRepository('TatweerTrainingBundle:Users')->find($trainingNeed->getRequestedForEmployee()->getIdUser());
            $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $userentity->getUsername())); // get user data from ACTIVE DIRECTORY 
            $userDataFromAD->employeeGrade   = $userentity->getEmployeeGrade();
            $userDataFromAD->idUser          = $trainingNeed->getRequestedForEmployee()->getIdUser();
         }
         
      
        $mpdf = new \mPDF('ar', 'A4',0,'',15,15,20,20,5,5,'L');
        $mpdf->useOnlyCoreFonts = true;
        $path = $this->get('kernel')->getRootDir() . '/../src/Tatweer/TrainingBundle/Resources/public/css/print.css';
        $stylesheet = file_get_contents($path); // external css
        $mpdf->WriteHTML($stylesheet,1);
        
        $html = $this->renderView('TatweerTrainingBundle:TrainingEvaluations:show.html.twig' ,  
        array(
            'entity'            => $entity,
            'form_sections'     => $form['sectionResult'],
            'form_criterias'    => $form['criteriasResult'],
            'form_options'      => $form['optionsResult'],
            'userentity'        => $userDataFromAD,
            'courseentity'      => $courseentity,
            'export_pdf'               => true
        )
                );

        $mpdf->WriteHTML($html, 2);
        $mpdf->Output($userentity->getEnglishFullname().'.pdf','I');
        
    }
    
}
