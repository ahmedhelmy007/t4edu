<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Users;
use Tatweer\TrainingBundle\Form\UsersType;
use Tatweer\TrainingBundle\Entity\Permissions;
use Symfony\Component\HttpFoundation\Response;
use Tatweer\TrainingBundle\Entity\Groups;


/**
 * Users controller.
 *
 * @Route("/users")
 */
class UsersController extends Controller
{
    
    private $departmentSystemRoles = array(2,4);
    private $groupSystemRoles      = array(3,5);
    private $trainingSystemRoles   = array(6,7,8,9);
    /**
     * Lists all Users entities.
     *
     * @Route("/", name="users")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = null;
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUsersAsList(array(3)); // current role id or specific role id 

        return array(
            'entities' => $entities,
            'data_result' => $data_result,
        );
    }

    /**
     * Login.
     *
     * @Route("/login", name="userlogin")
     * @Method("GET")
     * @Template()
     */
    public function loginAction(Request $request)
    {  
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }
    
    /**
     * @Route("/login_check", name="_user_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }
    
    
    
    /**
     * Lists all Users entities.
     *
     * @Route("/training/requests/individuals", name="_individualstrainingrequests")
     * @Template("TatweerTrainingBundle:Users/IndividualTraining:index.html.twig")
     */
    public function individualTrainingRequestsAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $params      = $this->getRequest()->request->all();
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUsersForIndividualTrainingRequests(); 
        $request     = $this->getRequest();
        
        if ( isset($params['save_indivisual_requests']) )
        {
            foreach ($data_result as $k => $v)
            {
                $userEntity = $em->getRepository('TatweerTrainingBundle:Users')->find($v['userid']);
                $userDataFromAD = $this->get('ad.serivce')->getUserResults(array( 'username' => $userEntity->getUsername() ));
                $fullname = ($request->getLocale() == 'ar' ? $userDataFromAD->FullArabicName : $userDataFromAD->DisplayName);
        
                if(isset($params['have_self_request'][$v['userid']])) 
                {
                    if(!$userEntity->getAbleToRequestTraining())
                    { 
                    $this->get('mail.serivce')->sendEmail('delivery@t4edu.com', $userDataFromAD->Email ,             
                        $this->renderView(
                            'TatweerTrainingBundle:MailTemplates:allow_individual_training_requests.html.twig',
                            array('name' => $fullname ) 
                        )
                        ,  $this->get('translator')->trans('Training requests Availability', array(), 'mail') 
                        );
                    }
                   // set indivisual request  
                    $userEntity->setAbleToRequestTraining(1);
                    $em->flush();
                }
                else  
                {
                    if($userEntity->getAbleToRequestTraining())
                    {
                       
                    $this->get('mail.serivce')->sendEmail('delivery@t4edu.com', $userDataFromAD->Email ,             
                        $this->renderView(
                            'TatweerTrainingBundle:MailTemplates:not_allow_individual_training_requests.html.twig',
                            array('name' => $fullname ) 
                        )
                        ,  $this->get('translator')->trans('Training requests Availability', array(), 'mail') 
                        );
                    }
                        // unset indivisual request 
                    $userEntity->setAbleToRequestTraining(NULL);
                    $em->flush();
               }
                        
            }
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('_individualstrainingrequests' ) );             
        }
        
        

        return array(
    
            'data_result' => $data_result,
            'pageSubTitle' => $this->get('translator')->trans('Users list' , array() , 'users')
        );
    }
    
 
    
    
    /**
     * Lists all Users entities.
     *
     * @Route("/training/members", name="_trainingdepartmentmembers")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Users/TrainingDepartment:index.html.twig")
     */
    public function trainingDepartmentMembersAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
 
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getTrainingDepartmentMembers(); 

        return array(
    
            'data_result' => $data_result,
            'pageSubTitle' => $this->get('translator')->trans('Users list' , array() , 'users')

        );
    }
    
    /**
     * Lists all Users entities.
     *
     * @Route("/evaluation", name="_evaluationuserlist")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:Users:userevaluationlist.html.twig")
     */
    public function usersEvaluationsListAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = null;
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUsersAsList(array(2,3)); // current role id or specific role id 

        return array(
            'entities' => $entities,
            'data_result' => $data_result,
            'pageSubTitle' => $this->get('translator')->trans('Users list' , array() , 'users')
            

        );
    }
    /**
     * Lists all Users entities.
     *
     * @Route("/trainingneeds", name="_trainingneedsuserlist")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneeduserlist.html.twig")
     */
    public function usersTrainingNeedListAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = null;
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUsersAsList(array(2,3)); // current role id or specific role id 

        return array(
            'entities' => $entities,
            'data_result' => $data_result,
        );
    }
    

 
    
    /**
     * Lists all Users entities.
     *
     * @Route("/followup/requests", name="_followuptrainingneedsuserlist")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneeduserlist.html.twig")
     */
    public function followupTrainingNeedsUserListAction( )
    {

        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = $note = null;

            if(!$em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
            {
                $note = $this->get('translator')->trans('There are no available active training needs period' , array() , 'messages');  
            }
            else 
            {
               
                $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUserListWithActions(array(2,3));
                
            }
      
        return array(
            'entities' => $entities,
            'data_result' => $data_result,
            'viewer' => true,
            
            'note' => $note
        );
    }
    /**
     * Lists all Users entities for trainer and HR dep.
     *
     * @Route("/followup/requests/hr", name="_followuprequestbytrainterandhr")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:TrainingNeeds/TrainerAndHr:trainingneeduserlist.html.twig")
     */
    public function TrainerHrfollowupTrainingNeedsUserListAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $viewer      = true;
        $entities = $note = null;

            if(! $em->getRepository('TatweerTrainingBundle:EvaluationPeriods')->hasOpenTrainingNeedsPeriod())
            {
                $note = $this->get('translator')->trans('There are no available active training needs period' , array() , 'messages');  
            } 
            else 
            {
                $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUserListWithActionsForTrainerAndHr(array(6,7,8)); // current role id or specific role id 
        
            }
        
            if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,8) )) // is Training Department Responsible or Training manager 
            {
                $viewer = FALSE; // he can update the training need request to add SUGGESTED TRAINING PROGRAMS (From HR)
            }
        return array(
            'entities' => $entities,
            'data_result' => $data_result,
            'viewer' => $viewer,
            'note' => $note
        );
    }
    /**
     * Lists all Users entities who have approved training requests from training department manager .
     *
     * @Route("/training/details/hr", name="_trainer_hr_trainingdetails")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:TrainingNeeds/TrainerAndHr:trainingneed_details_userlist.html.twig")
     */
    public function TrainerHrTrainingDetailsUserListAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = $note = null;
 
             
            //if(!$data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUserListApprovedByTrainingManager(array(6))) // current role id or specific role id 
            //{
            if($em->getRepository('TatweerTrainingBundle:Users')->hasPermission(0 , array(6,8,9) ))  
              $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUserListWithActionsForTrainerAndHrApprovedByTrainingManager(array(6,7,8,9)); // current role id or specific role id 
            //}
        return array(
            'entities' => $entities,
            'data_result' => $data_result,
            'note' => $note
        );
    }
    
    
    /**
     * Lists all Users entities who is approved by training department manager .
     *
     * @Route("/training/details", name="_trainingdetails")
     * @Method("GET")
     * @Template("TatweerTrainingBundle:TrainingNeeds:trainingneeduserlist.html.twig")
     */
    public function trainingDetailsUserListAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = false;
        $entities = $note = null;
 
            $data_result = $em->getRepository('TatweerTrainingBundle:Users')->getUserListWithDetailsActions(array(2,3));
                
        return array(
            'entities' => $entities,
            'data_result' => $data_result,
            'hasTrainingDetails' => true,
            'note' => $note
        );
    }
    /**
     * Update all Users entities from AD.
     *
     * @Route("/update/allusers", name="_updateallusersfromadlist")
     * @Method("GET")
     * @Template()
     */
    public function updateAllusersListFromADAction()
    {
  
        $em          = $this->getDoctrine()->getManager();
        $data_result = $userObj = new Users();
        $data_result = false;
        $entities = null;
        $data_result = $em->getRepository('TatweerTrainingBundle:Users')->findAll(); 
        foreach ($data_result as $k => $v)
        {
            if( $v->getUsername() != 'admin' )
            {
          $userDataFromAD = $this->get('ad.serivce')->getUserResults(array('username' => $v->getUsername()));   
            $v->setArabicFullname($userDataFromAD->FullArabicName);
            $v->setEnglishFullname($userDataFromAD->DisplayName);
            $em->flush();
            }
        }
        
    }
    
    /**
     * Creates a new Users entity.
     *
     * @Route("/", name="_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Users:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Users();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Users entity.
     *
     * @param Users $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Users $entity)
    {
        $form = $this->createForm(new UsersType(), $entity, array(
            'action' => $this->generateUrl('_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Users entity.
     *
     * @Route("/new", name="_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Users();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Users entity.
     *
     * @Route("/{id}", name="_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Edit assignesd Users grade and roles 
     *
     * @Route("/{groupid}/{userid}/editassign", name="_editassign")
     * @Template()
     */
    public function editassignAction($groupid , $userid)
    {
        $params = $this->getRequest()->request->all();
        $entity = new Users();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
        
        // if has a parent -> then its a group 
        $parent = $em->getRepository('TatweerTrainingBundle:Groups')->get_parent($groupid);
          if($parent[0]['parent'])
            $systemRoles = $this->groupSystemRoles;
          else 
               // its a department 
            $systemRoles = $this->departmentSystemRoles;
      
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
     
        if(isset($params['update_assign']))
        {
            $entity->setEmployeeGrade($params['employeeGrade']);
            $em->flush();

            
            foreach ($systemRoles as $dk => $dv)
            {
                $permissionResult = $em->getRepository('TatweerTrainingBundle:Permissions')->findBy(array('user'=>$userid , 'role'=>$dv , 'group' =>$groupid )) ;
               // if found in permission table and selected -> do nothing
              
               // 
               // 
               // if found in permission table and not selected -> delete 
                if($permissionResult && !in_array($dv, $params['userroles']))
                {
                    $em->remove($permissionResult[0]);
                }
                
               // if not found in permission table and selected -> insert 
                elseif(!$permissionResult && in_array($dv, $params['userroles']))
                {
                     $permissionObj = new Permissions();
                     $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
                     $createdByObj = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
                     $userObj      = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
                     $groupObj     = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
                     $roleObj      = $em->getRepository('TatweerTrainingBundle:Roles')->find($dv);
                     
                     $permissionObj->setCreatedBy($createdByObj);
                     $permissionObj->setGroup($groupObj);
                     $permissionObj->setUser($userObj);
                     $permissionObj->setRole($roleObj);
                     $em->persist($permissionObj);
                     
                   
                }
                $em->flush();

            }
            
                $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
                return $this->redirect($this->generateUrl('_editassign' , array('groupid' => $groupid , 'userid' => $userid)) );
        }
        
        $userRoles   = $em->getRepository('TatweerTrainingBundle:Users')->getUserAndSystemRoles( $userid , $groupid , $systemRoles );
        return array(
            'user'      => $entity,
            'userRoles'   => $userRoles,
        );
    }
   
    
   /* private function createEditassignForm(Users $entity , $group_id  , $userRoles ) // 
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->createQueryBuilder('Roles')->where('Roles.idRole IN (2,4)');
        
        $defaultData = array('form_title' => '');
        return $this->createFormBuilder($defaultData)
            ->setAction($this->generateUrl('_updateassign', array('groupid' => $group_id , 'userid' => $entity->getId())) )
            ->setMethod('PUT')
            ->add('employee_grade', 'text' , array('label' => $this->get('translator')->trans('Employee grade' , array() , 'users') , 'attr' => array('maxlength' => 3) , 'data' => $entity->getEmployeeGrade()  ) )
            ->add('roles',  'entity' , array(
                'class'    => 'Tatweer\TrainingBundle\Entity\Roles',
                            "multiple" => true,
                            "expanded" => true,
                            "label" => "Roles",
                            "choices" => $userRoles,
                'query_builder' => function(EntityRepository $er) {
               return $er->createQueryBuilder('Roles')->where('Roles.idRole IN (2,4)');}
                        ))
  
            ->add('search', 'submit', array('label' => 'Search' , 'validation_groups' => false))
            ->getForm();
    }
    
    */
    
    /**
    * Creates a form to edit a Users entity.
    *
    * @param Users $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
   /* private function createEditassignForm(Users $entity , $group_id , Permissions $userRoles)
    {
        $request = $this->getRequest();
        $em      = $this->getDoctrine()->getManager();
        $is_department = FALSE;
        
        IF( $em->getRepository('TatweerTrainingBundle:Groups')->findBy(array('parent' => NULL , 'idGroup' => $group_id)))
        {
                $is_department = TRUE;
        }
        
        $form = $this->createForm(new UpdateAssignUsersType(), $entity, array(
            'action' => $this->generateUrl('_updateassign', array('groupid' => $group_id , 'userid' => $entity->getId())),
            'method' => 'PUT',
            'locale' => $request->getLocale(),
            'is_department' => $is_department ,
        ));
      
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }*/
    /**
     * Edits an existing Users entity.
     *
     * @Route("/{groupid}/{userid}", name="_updateassign")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Users:editassign.html.twig")
     */
 /*   public function updateassignAction(Request $request, $groupid , $userid)
    {
        $entity    = new Users();
        $userRoles = array(); 
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

       
        $deleteForm  = $this->createDeleteForm($userid);
        $entityGroup = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
        
        $userRoles   = $em->getRepository('TatweerTrainingBundle:Users')->getUserRolesAsArray($userid , $groupid);
      //  print_r($userRoles);
        //$editForm->get('groupId')->getData();
       // $editForm->get('groupId')->setData($entityGroup);
        //$entity->setUsergroups($entityGroup);
         
        $editForm = $this->createEditassignForm($entity , $groupid , $userRoles );
        
        
        
        //$editForm->setData(array( 'groupId' => $entityGroup ));
        //$editForm->get('groupId')->setData($entityGroup);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

           // return $this->redirect($this->generateUrl('_editassign', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }*/
    /**
     * Displays a form to edit an existing Users entity.
     *
     * @Route("/{id}/edit", name="_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
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
    * Creates a form to edit a Users entity.
    *
    * @param Users $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Users $entity)
    {
        $form = $this->createForm(new UsersType(), $entity, array(
            'action' => $this->generateUrl('_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Users entity.
     *
     * @Route("/{id}", name="_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Users:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
      /*  $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );*/
    }
    /**
     * Deletes a training member entity.
     *
     * @Route("/{id}/training/members/delete", name="trainingmember_delete")
     * @Method("GET")
     */
    public function deleteMamberAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {

            $entity = $em->getRepository('TatweerTrainingBundle:Users')->getUserRoles($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            }
            foreach ($entity as $k => $v)
            {
            $permission = $em->getRepository('TatweerTrainingBundle:Permissions')->find($v['idPermission']); 
            $em->remove($permission);
            $em->flush();
            }
        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error

        }

           return $this->redirect($this->generateUrl('_trainingdepartmentmembers' ));
    }

    
        /**
     * Deletes a Users entity.
     *
     * @Route("/{groupid}/{userid}/remove", name="_remove")
     * @Method("GET")
     */
    public function removeAction(Request $request, $groupid , $userid)
    {

            $em = $this->getDoctrine()->getManager();
        if ($userid && $groupid) {

            $entity = $em->getRepository('TatweerTrainingBundle:Permissions')->findBy(array('user' =>$userid, 'group' => $groupid));

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Users entity.');
            }
            foreach ($entity as $k => $v)
            {
            $em->remove($v);
            $em->flush();
            }
            
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error

        }
        
            $entity = new Groups();
            $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($groupid);
                    
        if( $entity->getParent())
            return $this->redirect($this->generateUrl('groups_show', array('id' => $groupid )));
        else 
            return $this->redirect($this->generateUrl('departments_show', array('id' => $groupid )));

    }


    
    
    /**
     * Creates a form to delete a Users entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
    
    
    
      /**
      * hasOpenRequest ajax.
      *
      * @Route("/{id}/hasOpenRequest", name="users_hasOpenRequest")
      * 
       * return boolean , true if there an open request , false if not 
      */
    public function hasOpenRequest($id) {
       
         $has_open_request = FALSE;
         $em = $this->getDoctrine()->getManager();
         
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Users')->has_open_request($id) )
         {
             $has_open_request = TRUE;
         }  

         return new Response(json_encode($has_open_request), 200, array('Content-Type' => 'text/plain'));
    }
      /**
      * hasOpenRequest ajax.
      *
      * @Route("/{id}/trainingMemberHasOpenRequest", name="trainingMember_HasOpenRequest")
      * 
       * return boolean , true if there an open request , false if not 
      */
    public function trainingMemberHasOpenRequest($id) {
       
         $has_open_request = FALSE;
         $em = $this->getDoctrine()->getManager();
         
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Users')->has_open_request($id , true) )
         {
             $has_open_request = TRUE;
         }  

         return new Response(json_encode($has_open_request), 200, array('Content-Type' => 'text/plain'));
    }
    
    
    
    /**
     * Creates a search form for Active directory .
     * 
     * @return  form
     */
    private function createSearchForm()
    {
 
        
        $defaultData = array('form_title' => '');
        return $this->createFormBuilder($defaultData)
            ->setAction($this->generateUrl('member_assign'))
            ->setMethod('PUT')
            ->add('username', 'text' , array('label' => $this->get('translator')->trans('Domain user name' , array() , 'users') , 'attr' => array('maxlength' => 30) ) )
            //->add('employee_no', 'text' , array('label' => $this->get('translator')->trans('Employee No.' , array() , 'users') ,'attr' => array('maxlength' => 10) ) )
            //->add('ar_fullname', 'text' , array('label' => $this->get('translator')->trans('Arabic Fullname' , array() , 'users') ,'attr' => array('maxlength' => 70) ) )
            //->add('en_fullname', 'text' , array('label' => $this->get('translator')->trans('English Fullname' , array() , 'users') ,'attr' => array('maxlength' => 70) ) )
            ->add('search', 'submit', array('label' => 'Search' , 'validation_groups' => false))
            ->getForm();
    }
    
    /**
     * Displays a form to assign users.
     *
     * @Route("/training/members/assign", name="member_assign")
     *  
     * @Template("TatweerTrainingBundle:Users/TrainingDepartment:assign.html.twig")
     */
    public function assignTrainingMemberAction( Request $request )
    {
        
    $data = array();
    $result = $search_result = null;
    $em = $this->getDoctrine()->getManager();
    $inserted_users = $inserted_user_grades = array();
    
    // id assign user form is submitted 
    if($this->get('request')->request->get('assignusers'))
    {
        $this->assignusers(); 
        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
        return $this->redirect($this->generateUrl('_trainingdepartmentmembers'));
    }
    
    
    // generate search form
    $defaultData = array('form_title' => '');
    $form = $this->createSearchForm();
    
    //get all inserted users 
    if($result = $em->getRepository('TatweerTrainingBundle:Users')->getAssignedTrainingDepartmentMembers())    
     //get all inserted users grades 
    foreach ($result as $gk => $gv)
    {
    $inserted_users[]=$gv['user']['username'];
    }

    // get all employees grade
    
    
    $repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Users');
    $query = $repository->createQueryBuilder('p')->where('p.active = 1')->getQuery();
    $allusers_entity = $query->getArrayResult();
    
    foreach ($allusers_entity as $uk => $uv)
    {
    $inserted_user_grades[$uv['username']] = base64_decode($uv['employeeGrade']);
    }

 
    // get form array data 
    $form_data = $this->get('request')->request->get('form');
    // if submitted 
    if($form_data) 
    {
        $result= $this->get('ad.serivce')->getUserResults($form_data);
        if($result)
        {
            if(!is_array($result))
            {
              $search_result[0]=$result;  
            }
            else 
            {
              $search_result=$result;  
            }
        }
        else 
           $search_result = 'notdata'; 
    }
    
       
        return array(
     
            'form'                  => $form->createView(),
            'search_result'         => $search_result,
            'inserted_users'        => $inserted_users,
            'inserted_user_grades'  => $inserted_user_grades,
            'pageSubTitle' => $this->get('translator')->trans('Assign new users' , array() , 'messages')

        );

    }
    
        /**
      * Json1.
      *
      * @Route("/json1", name="users_json1")
      * 
      */
    public function json1() {
       
        $repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Roles');
        $query = $repository->createQueryBuilder('role')->where('role.idRole IN (6,7,8,9) ')->getQuery(); 
        
        $entity = $query->getArrayResult();
        return new Response(json_encode($entity), 200, array('Content-Type' => 'text/plain'));

    } 
    
    /**
     * assign users.
     */
    private function assignusers(){
        
        $em = $this->getDoctrine()->getManager();
        $date_time         = new \DateTime("now");
        $users             = $this->get('request')->request->get('users');
        $grade             = $this->get('request')->request->get('grade');
        $role              = $this->get('request')->request->get('role');
        $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
        $CreatedByObj          = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
        if($users)
        {
        foreach ($users as $k => $v)
        {
            

            // set user data 
            // 
            // check if user already exist then add only roles 
            $userObj = $em->getRepository('TatweerTrainingBundle:Users')->findByUsername($v);
            $userDataFromAD = $this->get('ad.serivce')->getUserResults(array('username' => $v)); 
            
            if(!$userObj)
            {
            $userObj = new Users();
            // else add new user record 
            $userObj->setUsername($v);
            $userObj->setArabicFullname($userDataFromAD->FullArabicName);
            $userObj->setEnglishFullname($userDataFromAD->DisplayName);
            //$userObj->setEmployeeGrade($grade[$v]); // to decode base64_decode($var);
            $userObj->setCreatedDate($date_time);
            $userObj->setActive(1);
            $em->persist($userObj);
            $em->flush();
            $user_id =  $userObj->getIdUser();
            }
            else 
            {
                // update grade number 
          //  $userObj[0]->setEmployeeGrade($grade[$v]); // to decode base64_decode($var);
            $user_id =  $userObj[0]->getIdUser();
            $userObj =  $userObj[0];
            $em->flush();
            }
            
            // add user roles 
            foreach ($role[$v] as $rk => $rv )
            {
            // check if role for this user in the selected department is already exist ? 
            $Permissions_entity      = $em->getRepository('TatweerTrainingBundle:Permissions')->findOneBy(
                    array(
                      'user' => $em->getRepository('TatweerTrainingBundle:Users')->find($user_id) 
                    , 'role' => $em->getRepository('TatweerTrainingBundle:Roles')->find($rv) 
                    , 'group' => NULL )
                    );
            if(! $Permissions_entity )
            {
            $permissionObj = new Permissions();  
            $permissionObj->setUser($userObj);
            
            $role_entity = $em->getRepository('TatweerTrainingBundle:Roles')->find($rv);
            $permissionObj->setRole($role_entity);
            
            $permissionObj->setGroup(NULL);
            
            $permissionObj->setCreatedDate($date_time);
            $permissionObj->setCreatedBy($CreatedByObj);
            $em->persist($permissionObj);
            $em->flush();
            }
            
            }

        }
        }
        
        
    }
    

    /**
     * Edit assignesd Users grade and roles 
     * @Route("/training/members/edit/{userid}", name="trainingmember_edit")
     * @Template("TatweerTrainingBundle:Users/TrainingDepartment:edit.html.twig")
     */
    public function editAssignedTrainigMemberAction($userid)
    {
        $params      = $this->getRequest()->request->all();
        $entity      = new Users();
        $em          = $this->getDoctrine()->getManager();
        $entity      = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
        $systemRoles = $this->trainingSystemRoles;

      
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
     
        if(isset($params['update_assign']))
        {
  
            foreach ($systemRoles as $dk => $dv)
            {
                $permissionResult = $em->getRepository('TatweerTrainingBundle:Permissions')->findBy(array('user'=>$userid , 'role'=>$dv , 'group' =>NULL )) ;
               // if found in permission table and selected -> do nothing
              
               // 
               // 
               // if found in permission table and not selected -> delete 
                if($permissionResult && !in_array($dv, $params['userroles']))
                {
                    $em->remove($permissionResult[0]);
                }
                
               // if not found in permission table and selected -> insert 
                elseif(!$permissionResult && in_array($dv, $params['userroles']))
                {
                     $permissionObj = new Permissions();
                     $CurrentLoggedInUserId = $em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId();
                     $createdByObj = $em->getRepository('TatweerTrainingBundle:Users')->find($CurrentLoggedInUserId);
                     $userObj      = $em->getRepository('TatweerTrainingBundle:Users')->find($userid);
                     $roleObj      = $em->getRepository('TatweerTrainingBundle:Roles')->find($dv);
                     
                     $permissionObj->setCreatedBy($createdByObj);
                     $permissionObj->setGroup(NULL);
                     $permissionObj->setUser($userObj);
                     $permissionObj->setRole($roleObj);
                     $em->persist($permissionObj);
                     
                   
                }
                $em->flush();

            }
            
                $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
                return $this->redirect($this->generateUrl('_trainingdepartmentmembers' ) );
        }
        
        $userRoles   = $em->getRepository('TatweerTrainingBundle:Users')->getUserAndSystemRoles( $userid , NULL , $systemRoles );
        return array(
            'user'      => $entity,
            'userRoles'   => $userRoles,
            'pageSubTitle' => $this->get('translator')->trans('Edit user' , array() , 'users')

        );
    }
}
