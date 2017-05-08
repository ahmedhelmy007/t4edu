<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tatweer\TrainingBundle\Entity\Groups;
use Tatweer\TrainingBundle\Form\GroupsType;
use Symfony\Component\HttpFoundation\Response;
use Tatweer\TrainingBundle\Entity\Permissions;
use Tatweer\TrainingBundle\Entity\Users;

/**
 * Groups controller.
 *
 * @Route("/groups")
 */
class GroupsController extends Controller
{

    /**
     * Lists all Groups entities.
     *
     * @Route("/", name="groups")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        // get all groups where parent_id ! NULL
        /*$repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Groups');
        $query = $repository->createQueryBuilder('p')
                ->where('p.parent <> :parentValue')
                ->setParameter('parentValue', 'NULL')
                ->orderBy('p.idGroup', 'ASC')
                ->getQuery();
        
        $entities = $query->getResult();
        
        return array(
            'entities' => $entities,
        );*/
    }

    
    /**
     * Creates a new Groups entity.
     *
     * @Route("/{parent_id}", name="groups_create")
     * @Method("POST")
     * @Template("TatweerTrainingBundle:Groups:new.html.twig")
     */
    public function createAction(Request $request , $parent_id)
    {
        $entity = new Groups();
        $form = $this->createCreateForm($entity,$parent_id);
        $form->handleRequest($request);
         

        
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $parent_entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($parent_id);
            $entity->setParent($parent_entity);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data saved successfully' , array() , 'conformation')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('groups_show' , array('id' => $entity->getIdGroup())));
            
           // return $this->redirect($this->generateUrl('groups_show', array('id' => $entity->getIdGroup())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Group creation' , array() , 'groups')
        );
    }

    /**
     * Creates a form to create a Groups entity.
     *
     * @param Groups $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Groups $entity , $parent_id )
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new GroupsType($translator), $entity, array(
            'action' => $this->generateUrl('groups_create', array('parent_id' => $parent_id )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Groups entity.
     *
     * @Route("/{parent_id}/new", name="groups_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($parent_id)
    {
        //$em = $this->getDoctrine()->getManager();
        $entity = new Groups();
        //$entity->setParent($em->getRepository('TatweerTrainingBundle:Groups')->find($parent_id));
        $form   = $this->createCreateForm($entity , $parent_id);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Group creation' , array() , 'groups')
        );
    }

    /**
     * Finds and displays a Groups entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $data_result = $groups = false;
        $employeeUsers = $group_leader_names = $group_leaderUsers = $employeeUsers =  array();
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);

        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        

	
        $entities = $em->getRepository('TatweerTrainingBundle:Groups')->findBy(array('parent' => $id , 'deleted' => 0));
        foreach ($entities as $k=>$v)
        {
            $group_leader    = $em->getRepository('TatweerTrainingBundle:Groups')->getAssignUsers($v->getIdGroup() , array(3));
            $employeeUsers    = $em->getRepository('TatweerTrainingBundle:Groups')->getAssignUsers($v->getIdGroup() , array(5));
            $group_leader_names = array();
                    foreach ($group_leader as $rk => $rv)
                    {
                      //  $user_data = $this->get('ad.serivce')->getUserResults(array('username' => $rv['user']['username']));
                        $group_leader_names[] = ($locale == 'ar' ? $rv['user']['arabicFullname'] : $rv['user']['englishFullname']);
                    }
                    
                    foreach ($employeeUsers as $sk => $sv)
                    {
                      //  $user_data = $this->get('ad.serivce')->getUserResults(array('username' => $sv['user']['username']));
                        $employeeUsers_names[] = ($locale == 'ar' ? $sv['user']['arabicFullname'] : $sv['user']['englishFullname']);
                    }
            if(isset($group_leader_names))
            $group_leaderUsers[$v->getIdGroup()] = $group_leader_names;
            if(isset($employeeUsers_names))
            $employeeUsers[$v->getIdGroup()] = $employeeUsers_names;
            
            
        }
        // get assigned users with role 3 or 5 
        $result = $em->getRepository('TatweerTrainingBundle:Groups')->getAssignUsers($id , array(3,5));
        
        foreach ($result as $k => $v)
        {

        $userDataFromAD                  = $this->get('ad.serivce')->getUserResults(array('username' => $v['user']['username'])); // get user data from ACTIVE DIRECTORY 
        $userDataFromAD                  = get_object_vars($userDataFromAD);
        $userDataFromAD['employeeGrade'] = base64_decode($v['user']['employeeGrade']);
        $userDataFromAD['idUser']        = $v['user']['idUser'];
        $user_roles                      = $em->getRepository('TatweerTrainingBundle:Groups')->getUserRoles($v['user']['idUser'] , $id);
        $userDataFromAD['employeeRoles'] = implode(',', $user_roles['roles_'.$locale]);
        $data_result[]                   = $userDataFromAD;
       
        }
 
        $groups = $em->getRepository('TatweerTrainingBundle:Groups')->findBy(array('parent' =>$id, 'deleted' => 0));
        
        return array(
            'entity'      => $entity,
            'data_result' => $data_result,
            'group_result'=> $groups,
            'group_leaderUsers' => $group_leaderUsers ,
            'employeeUsers' => $employeeUsers ,
            'pageSubTitle' => $this->get('translator')->trans('View details' , array() , 'messages')
        );
    }

    /**
     * Displays a form to edit an existing Groups entity.
     *
     * @Route("/{id}/edit", name="groups_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id , $type = 'groups' )
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $editForm = $this->createEditForm($entity , $type);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Group edit' , array() , 'groups')
        );
    }
    /**
     * Displays a form to edit an existing Department entity.
     *
     * @Route("/{id}/edit", name="departments_edit")
     * @Method("GET")
     * @Template()
     */
    public function editDepartmentAction($id)
    {
        return $this->editAction($id , 'departments');
    }

    /**
    * Creates a form to edit a Groups entity.
    *
    * @param Groups $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Groups $entity )
    {
        $translator = $this->get('translator');
        $form = $this->createForm(new GroupsType($translator), $entity, array(
            'action' => $this->generateUrl('groups_update', array('id' => $entity->getIdGroup())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Groups entity.
     *
     * @Route("/{id}", name="groups_update")
     * @Method("PUT")
     * @Template("TatweerTrainingBundle:Groups:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Groups entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data has been saved successfully')); // add flash messages alert-error
            return $this->redirect($this->generateUrl('groups_edit' , array('id' => $id)));
            
          
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pageSubTitle' => $this->get('translator')->trans('Group edit' , array() , 'groups')
        );
    }
    

    
      /**
      * hasOpenRequest.
      *
      * @Route("/{id}/hasOpenRequest", name="groups_hasOpenRequest")
      * 
       * return boolean , true if there an open request , false if not 
      */
    public function hasOpenRequest($id) {
       
         $group_child      = FALSE;
         $has_open_request = FALSE;
         $em = $this->getDoctrine()->getManager();
         
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Groups')->has_open_request($id) )
         {
             
             $has_open_request = TRUE;
         }  
         
         // get childs 
              $group_child = $em->getRepository('TatweerTrainingBundle:Groups')->get_child($id);
              $childs_idGroups = array_map('current', $group_child);

         while ($childs_idGroups && !$has_open_request )
         {
             
         if( $open_request = $em->getRepository('TatweerTrainingBundle:Groups')->has_open_request($childs_idGroups) )
         {

             $has_open_request = TRUE;
         }  
          else
         {
              $group_child = $em->getRepository('TatweerTrainingBundle:Groups')->get_child($childs_idGroups);
              $childs_idGroups = array_map('current', $group_child);
         }
         
         
         }
         
         return new Response(json_encode($has_open_request), 200, array('Content-Type' => 'text/plain'));
    }
    
    
    
    /**
     * Deletes a Groups entity.
     *
     * @Route("/{id}/delete", name="groups_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        if ($id) 
        {
            $entity = new Groups();
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Groups entity.');
            }

            $entity->setDeleted(1);
            $em->flush();
        }
        
        $this->get('session')->getFlashBag()->add('alert-success', $this->get('translator')->trans('Data deleted successfully' , array() , 'conformation')); // add flash messages alert-error
        if( $entity->getParent()->getParent())
            return $this->redirect($this->generateUrl('groups_show', array('id' => $entity->getParent()->getIdGroup() )));
        else 
            return $this->redirect($this->generateUrl('departments_show', array('id' => $entity->getParent()->getIdGroup() )));
        
    }

    /**
     * Creates a form to delete a Groups entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groups_delete', array('id' => $id)))
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
            ->setAction($this->generateUrl('groups_assign', array('id' => $id)))
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
     * @Route("/{id}/assign", name="groups_assign")
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
        return $this->redirect($this->generateUrl('groups_show', array('id' => $id)));
    }
    
    
    // generate search form
    $defaultData = array('form_title' => '');
    $form = $this->createSearchForm($id);
    
    //get all inserted users 
    if($result = $em->getRepository('TatweerTrainingBundle:Groups')->getAssignUsers($id , array(3,5)))    
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
  
    
    
    
    $entity = $em->getRepository('TatweerTrainingBundle:Groups')->find($id);
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
      * @Route("/{id}/json1", name="groups_json1")
      * 
      */
    public function json1($id) {
       
        $repository = $this->getDoctrine()->getRepository('TatweerTrainingBundle:Roles');
        $query = $repository->createQueryBuilder('role')->where('role.idRole IN (3,5) ')->getQuery(); 
        
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
  

    if($users)    
    {
        foreach ($users as $k => $v)
        {
            

            // set user data 
            // 
            // check if user already exist then add only roles 
            $userObj    = $em->getRepository('TatweerTrainingBundle:Users')->findByUsername($v);
            $userDataFromAD = $this->get('ad.serivce')->getUserResults(array('username' => $v)); 
         
            if(!$userObj)
            {
            $userObj = new Users();
            // else add new user record 
            $userObj->setUsername($v);
            $userObj->setEmployeeGrade($grade[$v]); // to decode base64_decode($var);
            $userObj->setArabicFullname($userDataFromAD->FullArabicName);
            $userObj->setEnglishFullname($userDataFromAD->DisplayName);
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
            $user_entity = $em->getRepository('TatweerTrainingBundle:Users')->find(1);
            $permissionObj->setCreatedBy($user_entity);
            $em->persist($permissionObj);
            $em->flush();

            }
            
            }

        }
    }
        
        
    }
       
   
}
