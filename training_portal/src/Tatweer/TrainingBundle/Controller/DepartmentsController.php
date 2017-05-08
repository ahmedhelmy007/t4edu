<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Departments;
use Tatweer\TrainingBundle\Form\DepartmentsType;
use Symfony\Component\HttpFoundation\Response;
use Tatweer\TrainingBundle\Entity\Permissions;
use Tatweer\TrainingBundle\Entity\Users;


/**
 * Departments controller.
 *
 * @Route("/departments")
 */
class DepartmentsController extends Controller
{
 
    /**
     * Lists all Departments entities.
     *
     * @Route("/", name="departments")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities = new Departments();
        $em = $this->getDoctrine()->getManager();
        $assignedUsers = FALSE;
        $request = $this->getRequest();
        $locale = $request->getLocale();
        
        $dep_managerUsers= array();
	$dep_structure_responsUsers = array();
        if($this->get('auth.serivce')->isSuperAdmin())
        $entities = $em->getRepository('TatweerTrainingBundle:Departments')->findBy(array('parent' => NULL, 'deleted' => 0));
        else
        $entities = $em->getRepository('TatweerTrainingBundle:Departments')->getRelatedDepartments();
        foreach ($entities as $k=>$v)
        {
            $dep_managers    = $em->getRepository('TatweerTrainingBundle:Departments')->getAssignUsers($v->getIdGroup() , array(2));
            $dep_structure_respons    = $em->getRepository('TatweerTrainingBundle:Departments')->getAssignUsers($v->getIdGroup() , array(4));

            
            $dep_structure_respons_names= array();
            $dep_managers_names = array();

                    foreach ($dep_managers as $rk => $rv)
                    {
                        //$user_data = $this->get('ad.serivce')->getUserResults(array('username' => $rv['user']['username']));
                        $dep_managers_names[] = ($locale == 'ar' ? $rv['user']['arabicFullname'] : $rv['user']['englishFullname']);
                    }
                    
                    foreach ($dep_structure_respons as $sk => $sv)
                    {
                        //$user_data = $this->get('ad.serivce')->getUserResults(array('username' => $sv['user']['username']));
                        $dep_structure_respons_names[] = ($locale == 'ar' ? $sv['user']['arabicFullname'] : $sv['user']['englishFullname']);
                    }

   
                    
            if(isset($dep_managers_names))        
            $dep_managerUsers[$v->getIdGroup()] = $dep_managers_names;
            if(isset($dep_structure_respons_names))  
            $dep_structure_responsUsers[$v->getIdGroup()] = $dep_structure_respons_names;
            
            
        }
       
        return array(
            'entities' => $entities,
            'dep_managerUsers' => $dep_managerUsers ,
            'dep_structure_respons' => $dep_structure_responsUsers ,
            'pageSubTitle' => $this->get('translator')->trans('Departments List' , array() , 'departments')


            //'group_leaderUsers' => $group_leaderUsers ,
        );
    }
    /**
     * Creates a new Departments entity.
     *
     * @Route("/", name="departments_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Departments:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $ack_msg = $ack_type = "";
        $date_time = new \DateTime("now");
        $entity = new Departments();
        //$entity->setCreatedDate($date_time);
        $form = $this->createCreateForm($entity);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //$ack_msg ='Successfully created'; 
            //$ack_type='success';

            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('departments_new'));

            //return $this->redirect($this->generateUrl('departments_show', array('id' => $entity->getIdGroup() )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'ack_msg' => $ack_msg ,
            'ack_type' => $ack_type,
            'pageSubTitle' => $this->get('translator')->trans('Department creation' , array() , 'departments')
        );
    }

    /**
     * Creates a form to create a Departments entity.
     *
     * @param Departments $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Departments $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new DepartmentsType($translator), $entity, array(
            'action' => $this->generateUrl('departments_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Departments entity.
     *
     * @Route("/new", name="departments_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Departments();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Department creation' , array() , 'departments')
        );
    }

    /**
     * Finds and displays a Departments entity.
     *
     * @Route("/{id}", name="departments_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $data_result = $groups = $group_leaderUsers = false;
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $group_leader_names= array();
    
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Departments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departments entity.');
        }



        // get assigned users with role 2 or 4 
        $result = $em->getRepository('TatweerTrainingBundle:Departments')->getAssignUsers($id , array(2,4));
        
        foreach ($result as $k => $v)
        {

        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $v['user']['username'])); // get user data from ACTIVE DIRECTORY 
        $userDataFromAD                  = get_object_vars($userDataFromAD);
        $userDataFromAD['employeeGrade'] = base64_decode($v['user']['employeeGrade']);
        $userDataFromAD['idUser']        = $v['user']['idUser'];
        $user_roles                      = $em->getRepository('TatweerTrainingBundle:Departments')->getUserRoles($v['user']['idUser'] , $id);
        $userDataFromAD['employeeRoles'] = implode(',', $user_roles['roles_'.$locale]);
        $data_result[]                   = $userDataFromAD;
       
        }
        
        $groups = $em->getRepository('TatweerTrainingBundle:Groups')->findBy(array('parent' =>$id, 'deleted' => 0));
        foreach ($groups as $k=>$v)
        {
            $group_leader_names = array();
            $group_leader    = $em->getRepository('TatweerTrainingBundle:Groups')->getAssignUsers($v->getIdGroup() , array(3));
    


                    foreach ($group_leader as $gk => $gv)
                    {
                        $user_data = $this->get('ad.serivce')->getUserResults(array('username' => $gv['user']['username']));
                        $group_leader_names[] = ($locale == 'ar' ? $gv['user']['arabicFullname'] : $gv['user']['englishFullname']);
                    }
            if(isset($group_leader_names))        
            $group_leaderUsers[$v->getIdGroup()] = $group_leader_names;
            
            
        }
  

        return array(
            'entity'      => $entity,
            'data_result' => $data_result,
            'group_result'=> $groups,
            'group_leaderUsers' => $group_leaderUsers ,
            'pageSubTitle' => $this->get('translator')->trans('View details' , array() , 'messages')


        );
    }

    /**
     * Displays a form to edit an existing Departments entity.
     *
     * @Route("/{id}/edit", name="departments_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Departments')->find($id);
       
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departments entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Department edit' , array() , 'departments')
        );
    }

    /**
    * Creates a form to edit a Departments entity.
    *
    * @param Departments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Departments $entity)
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new DepartmentsType($translator), $entity, array(
            'action' => $this->generateUrl('departments_update', array('id' => $entity->getIdGroup())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Departments entity.
     *
     * @Route("/{id}", name="departments_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Departments:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $ack_msg = $ack_type = "";
      
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Departments')->find($id);
        
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Departments entity.');
        }
      
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            //$ack_msg ='Successfully updated'; 
           // $ack_type='success';
            //return $this->redirect($this->generateUrl('departments_edit', array('id' => $id)));
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data updated successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('departments_edit' , array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'ack_msg' => $ack_msg ,
            'ack_type' => $ack_type,
            'pageSubTitle' => $this->get('translator')->trans('Department edit' , array() , 'departments')
        );
    }
    
    
    
      /**
      * hasOpenRequest.
      *
      * @Route("/{id}/hasOpenRequest", name="departments_hasOpenRequest")
      * 
       * return boolean , true if there an open request , false if not 
      */
    public function hasOpenRequest($id) {
       
         $group_child      = FALSE;
         $has_open_request = FALSE;
         $em = $this->getDoctrine()->getManager();
         
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Departments')->has_open_request($id) )
         {
              
             $has_open_request = TRUE;
         }  
         
         // get childs 
              $group_child = $em->getRepository('TatweerTrainingBundle:Departments')->get_child($id);
              $childs_idGroups = array_map('current', $group_child);

         while ($childs_idGroups && !$has_open_request )
         {
             
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Departments')->has_open_request($childs_idGroups) )
         {

             $has_open_request = TRUE;
         }  
          else
         {
              $group_child = $em->getRepository('TatweerTrainingBundle:Departments')->get_child($childs_idGroups);
              $childs_idGroups = array_map('current', $group_child);
         }
         
         
         }
         
         return new Response(json_encode($has_open_request), 200, array('Content-Type' => 'text/plain'));
    }
    
    
    /**
     * Deletes a Departments entity.
     *
     * @Route("/{id}/delete", name="departments_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        if($id)
        {
            $entity = new Departments();
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:Departments')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Departments entity.');
            }

            $entity->setDeleted(1);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error
        return $this->redirect($this->generateUrl('departments'));

    }

    /**
     * Creates a form to delete a Departments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('departments_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
    /**
     * Creates a search form for Active directory .
     *
     * @param mixed $id The entity id
     * 
     * @return  form
     */
    private function createSearchForm($id)
    {
 
        
        $defaultData = array('form_title' => '');
        return $this->createFormBuilder($defaultData)
            ->setAction($this->generateUrl('departments_assign', array('id' => $id)))
            ->setMethod('PUT')
            ->add('username', 'text' , array('label' => $this->get('translator')->trans('Domain user name' , array() , 'users') , 'attr' => array('maxlength' => 30) ) )
            ->add('employee_no', 'text' , array('label' => $this->get('translator')->trans('Employee No.' , array() , 'users') ,'attr' => array('maxlength' => 10) ) )
            ->add('ar_fullname', 'text' , array('label' => $this->get('translator')->trans('Arabic Fullname' , array() , 'users') ,'attr' => array('maxlength' => 70) ) )
            ->add('en_fullname', 'text' , array('label' => $this->get('translator')->trans('English Fullname' , array() , 'users') ,'attr' => array('maxlength' => 70) ) )
            ->add('search', 'submit', array('label' => 'Search' , 'validation_groups' => false))
            ->getForm();
    }
    
    /**
     * Displays a form to assign users.
     *
     * @Route("/{id}/assign", name="departments_assign")
     *  
     * @Template()
     */
    public function assignAction( Request $request ,$id )
    {
        
    $data = array();
    $result = $search_result = null;
    $em = $this->getDoctrine()->getManager();
    $inserted_users = $inserted_user_grades = array();
    
    // id assign user form is submitted 
    if($this->get('request')->request->get('assignusers'))
    {
        $this->assignusers($id); 
        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
        return $this->redirect($this->generateUrl('departments_show', array('id' => $id)));
    }
    
    
    // generate search form
    $defaultData = array('form_title' => '');
    $form = $this->createSearchForm($id);
    
    //get all inserted users 
    if($result = $em->getRepository('TatweerTrainingBundle:Departments')->getAssignUsers($id , array(2,4)))    
     //get all inserted users grades 
    foreach ($result as $gk => $gv)
    {
    $inserted_users[]=$gv['user']['username'];
    //$inserted_user_grades[$gv['user']['username']] = base64_decode($gv['user']['employeeGrade']);
    }

    // get all employees grade
    
    
    $repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Users');
    $query = $repository->createQueryBuilder('p')->where('p.active = 1')->getQuery();
    $allusers_entity = $query->getArrayResult();
    
    foreach ($allusers_entity as $uk => $uv)
    {
    $inserted_user_grades[$uv['username']] = base64_decode($uv['employeeGrade']);
    }
  
    
    
    
    $entity = $em->getRepository('TatweerTrainingBundle:Departments')->find($id);
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
            'entity'                => $entity,
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
      * @Route("/{id}/json1", name="departments_json1")
      * 
      */
    public function json1($id) {
       
        $repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Roles');
        $query = $repository->createQueryBuilder('role')->where('role.idRole IN (2,4) ')->getQuery(); 
        
        $entity = $query->getArrayResult();
        return new Response(json_encode($entity), 200, array('Content-Type' => 'text/plain'));

    }
    /**
     * assign users.
     */
    private function assignusers($id){
        
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
            $userObj->setEmployeeGrade($grade[$v]); // to decode base64_decode($var);
            $userObj->setCreatedDate($date_time);
            $userObj->setActive(1);
            $em->persist($userObj);
            $em->flush();
            $user_id =  $userObj->getIdUser();
            }
            else 
            {
                // update grade number 
            $userObj[0]->setEmployeeGrade($grade[$v]); // to decode base64_decode($var);
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
                    , 'group' => $em->getRepository('TatweerTrainingBundle:Groups')->find($id) )
                    );
            if(! $Permissions_entity )
            {
            $permissionObj = new Permissions();  
            $permissionObj->setUser($userObj);
            
            $role_entity = $em->getRepository('TatweerTrainingBundle:Roles')->find($rv);
            $permissionObj->setRole($role_entity);
            
            $group_entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);
            $permissionObj->setGroup($group_entity);
            
            $permissionObj->setCreatedDate($date_time);
 
            $permissionObj->setCreatedBy($CreatedByObj);
            $em->persist($permissionObj);
            $em->flush();
            }
            
            }

        }
        }
        
        
    }
       
    
}
