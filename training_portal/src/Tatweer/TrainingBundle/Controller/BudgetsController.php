<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Budgets;
use Symfony\Component\HttpFoundation\Response;
use Tatweer\TrainingBundle\Form\BudgetForDepartmentType;
use Tatweer\TrainingBundle\Form\BudgetsType;
use Tatweer\TrainingBundle\Entity\DepartmentBudgets;



/**
 * Budgets controller.
 *
 * @Route("/budgets")
 */
class BudgetsController extends Controller
{

        

    
    
    /**
     * Lists all Budgets entities.
     *
     * @Route("/", name="budgets")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('TatweerTrainingBundle:Budgets')
                ->findByDeleted('0');
        
        //create a delete button for each entity in index page.
        //See: http://stackoverflow.com/questions/18432599/symfony2-how-to-delete-an-entity-from-a-template-with-a-list-of-entities-crud
        $deleteForms = array();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }

        return array(
            'entities' => $entities,
            'deleteForms' => $deleteForms,
            'pageSubTitle' => $this->get('translator')->trans('Budgets list' , array() , 'budgets')
        );
    }
    /**
     * Creates a new Budgets entity.
     *
     * @Route("/", name="budgets_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Budgets:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Budgets();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$entity->setStartDate(new \DateTime($entity->getStartDate()));
            //$entity->setEndDate(new \DateTime($entity->getEndDate()));
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('budgets'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Create new budget' , array() , 'budgets')
        );
    }

    /**
     * Creates a form to create a Budgets entity.
     *
     * @param Budgets $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Budgets $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new BudgetsType($translator), $entity, array(
            'action' => $this->generateUrl('budgets_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Budgets entity.
     *
     * @Route("/new", name="budgets_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Budgets();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Create new budget' , array() , 'budgets')
        );
        
        
       /* $entity = new Budgets();
        
        $em = $this->getDoctrine()->getManager();
        $departments = $em->getRepository('TatweerTrainingBundle:Departments')->findAll();
        foreach ($departments as $department) {
            $entity->setDepartments($department);
        }
        $form   = $this->createForm(new \Tatweer\TrainingBundle\Form\BudgetForDepartmentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
       
        */
    }

    
    /**
     * Edits an existing TrainingExpensesClasses entity.
     *
     * @Route("/{id}", name="department_budget_update")
     * @Method("PUT")
     * @Template()
     */
    public function updateDepartmentBudgetAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrainingExpensesClasses entity.');
        }

     
        $editForm = $this->createForm(new BudgetForDepartmentType(), $entity , array(
            'action' => $this->generateUrl('department_budget_update', array('id' => $id )),
            'method' => 'PUT',
        ));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Edit budget' , array() , 'budgets')
        );
    }

    
    /**
     * Finds and displays a Budgets entity.
     *
     * @Route("/{id}", name="budgets_show")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $em                    = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();

        $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }
    /*    if( $departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->findBy(array( 'budget'=> $id , 'department'=>128 ) ))
            echo $departmentBudget[0]->getOriginalValue();*/
            
        if( isset($params['save_department_budget']) )
        {
            $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
            $actorObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
            // save department budget data 
            foreach ($params['department_budget']  as $k => $v)
            {
              
                if($departmentBudgetObj = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->findBy( array( 'budget' => $id , 'department'  => $k) ))
                {
                    if($v != $departmentBudgetObj[0]->getOriginalValue() )
                    {
                    $departmentBudgetObj[0]->setOriginalValue($v);
                    $departmentBudgetObj[0]->setRemainingValue($v);
                    $departmentBudgetObj[0]->setModifiedBy($actorObj);
                    }
                }
                else 
                {
                 if($v)
                  {
                    $departmentEntity = $em->getRepository('TatweerTrainingBundle:Departments')->find($k);
                    $departmentBudgetObj = new DepartmentBudgets();
                    $departmentBudgetObj->setOriginalValue($v);
                    $departmentBudgetObj->setRemainingValue($v);
                    $departmentBudgetObj->setBudget($entity);
                    $departmentBudgetObj->setCreatedBy($actorObj);
                    $departmentBudgetObj->setDepartment($departmentEntity);
                    $em->persist($departmentBudgetObj);
                  }
                }
                $em->flush();
                
            }
                        
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('budgets'));
        }
        /*$bd_form = $this->createForm(new BudgetForDepartmentType(), $entity , array(
            'action' => $this->generateUrl('department_budget_update', array('id' => $id )),
            'method' => 'PUT',
        ));
        $bd_form->add('submit', 'submit', array('label' => 'Update'));
        */
        $departments = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->getAllDepartmentAndBudgets($id);
        return array(
            'entity'      => $entity,
            'departments' => $departments,
            'pageSubTitle' => $this->get('translator')->trans('View details' , array() , 'messages')
            //'form' => $bd_form->createView(),
        );
        
        //$deleteForm = $this->createDeleteForm($id);
        
        //get all Depts to generate a form for each one to assign budget for them
       /* $departments = $em->getRepository('TatweerTrainingBundle:Departments')->findAll();

        //create an array of edit DepartmentBudgets in the following form:
        //array( [department_id] => array( [departmentBudget_id] =>  $DepartmentBudgetForm ),
        //       [department_id] => array( [departmentBudget_id] =>  $DepartmentBudgetForm ))
        $departmentBudgetsForms = array();
        $departmentBudget = null;
        foreach ($departments as $department) {
            //$em = $this->getDoctrine()->getManager();
            //$departmentBudget = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->findByDepartment($department->getId());
            //echo $departmentBudget[0]->getId();
            
            $dp = $this->getDoctrine() ->getRepository('TatweerTrainingBundle:DepartmentBudgets');
            $dpQuery = $dp->createQueryBuilder('DB')
                ->where('DB.budget = :budget_id')
                ->andWhere('DB.department = :department_id')
                ->setParameter( 'budget_id', $id)
                ->setParameter( 'department_id',  $department->getId())
                ->getQuery();
            
            $departmentBudget = $dpQuery->getResult();

            if ($departmentBudget) {
                $deptBudgetId= $departmentBudget[0]->getId();
                $departmentBudget= $departmentBudget[0];
            } else {
                $deptBudgetId= 0;
                $departmentBudget= null;
            }
            $departmentBudgetsForms[$department->getId()] = array( $deptBudgetId => $this->createForm(new \Tatweer\TrainingBundle\Form\BudgetForDepartmentType(), $entity )->createView() );

        }
//        print_r($departmentBudgetsForms[3][2]);

        return array(
            'entity'      => $entity,
           // 'delete_form' => $deleteForm->createView(),
            'departments' => $departments,
            'edit_dept_budget_forms'   => $departmentBudgetsForms,
        );*/
    }

    /**
     * Displays a form to edit an existing Budgets entity.
     *
     * @Route("/{id}/edit", name="budgets_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        
      
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }  
        
        $editForm = $this->createEditForm($entity);
            return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Edit budget' , array() , 'budgets')
        );
        
        
        
        
     /*   $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        //get all Depts to generate a form for each one to assign budget for them
        $departments = $em->getRepository('TatweerTrainingBundle:Departments')->findAll();

        $editForm = $this->createForm(new \Tatweer\TrainingBundle\Form\BudgetForDepartmentType(
                array('departments' => $departments, 'budget' => $entity)), $entity);
        //$editForm->add('submit', 'submit', array('label' => 'Update'));

        
//echo "<pre>";
//\Doctrine\Common\Util\Debug::dump($editForm);
//            $em->flush();echo "</pre>";
            
            
            return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'departments' => $departments,
//            'edit_dept_budget_forms'   => $departmentBudgetsForms,
        );*/
    }

    /**
    * Creates a form to edit a Budgets entity.
    *
    * @param Budgets $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Budgets $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new BudgetsType($translator), $entity, array(
            'action' => $this->generateUrl('budgets_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Budgets entity.
     *
     * @Route("/{id}", name="budgets_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Budgets:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Budgets entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('budgets'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Edit budget' , array() , 'budgets')
        );
    }
    /**
     * Deletes a Budgets entity.
     *
     * @Route("/delete/{id}", name="budgets_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        //$form = $this->createDeleteForm($id);
        //$form->handleRequest($request);

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:Budgets')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Budgets entity.');
            }

            //set `deleted` field to 1 (mark as deleted)
            $repository = $this->getDoctrine()
                ->getRepository('TatweerTrainingBundle:Budgets');
            $qb = $repository->createQueryBuilder('TatweerTrainingBundle:Budgets');
            $q = $qb->update('TatweerTrainingBundle:Budgets b')
                ->set('b.deleted', 1)
                ->where('b.idBudget = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
        }

        return $this->redirect($this->generateUrl('budgets'));
    }

    /**
     * Creates a form to delete a Budgets entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('budgets_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
 

       
      /**
      * deductedTrainingRequest ajax.
      *
      * @Route("/{id}/deductedTrainingRequest", name="budgets_deductedTrainingRequest")
      * 
       * return boolean , true if there an open request , false if not 
      */
    public function deductedTrainingRequest($id) {
       
         $found = FALSE;
         $em = $this->getDoctrine()->getManager();
         
         $found = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->deductedTrainingRequests($id);
 

         return new Response(json_encode($found), 200, array('Content-Type' => 'text/plain'));
    }
    
    
    /**
     * check department budget
     *
     * @Route("/{id}/{department_id}/{value}/checkDepartmentBudget", name="check_department_budget")
       * return boolean 
     */
    public function checkDepartmentBudget($id , $department_id , $value )
    {
        $return = false;
        $em = $this->getDoctrine()->getManager();
        $return = $em->getRepository('TatweerTrainingBundle:DepartmentBudgets')->canUpdateDepartmentBudget($id , $department_id , $value);
     return new Response(json_encode($return), 200, array('Content-Type' => 'text/plain'));
    }
}
