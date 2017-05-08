<?php

namespace Tatweer\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Default controller.
 *
 * @Route("/default")
 */
class DefaultController extends Controller
{
   /**
     * index
     *
     * @Route("/", name="default")
     * 
     * @Template("TatweerTrainingBundle:Default:index.html.twig")
     */
    
    public function indexAction()
    {
        return $this->render('TatweerTrainingBundle:Default:index.html.twig');
    }
    
   /**
     * login
     *
     * @Route("/login", name="_login")
     * 
     * @Template("TatweerTrainingBundle:Default:login.html.twig")
     */
    public function loginAction()
    {
        $em                    = $this->getDoctrine()->getManager();
        $params                = $this->getRequest()->request->all();
        
        if($this->get('auth.serivce')->isLoggedIn())
            return $this->redirect($this->generateUrl('tatweer_training_homepage'));
        
        if(isset($params['login_btn']) )
        {
            
            if($entity = $em->getRepository('TatweerTrainingBundle:Users')->findByUsername($params['username']))
            {
                // set session 
                $session     = new Session();
                $session->set('username' , $params['username']); 
                $session->set('arabic_full_name' , $entity[0]->getArabicFullname()); 
                $session->set('english_full_name' , $entity[0]->getEnglishFullname()); 
                $session->set('validated' , true); 
                
                $groupList  = $em->getRepository('TatweerTrainingBundle:Groups')->getUserGroups($em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId());
     
                        foreach($groupList as $k => $v)
                        {
                            if(is_null($v['groupid']))
                            {
                              $groupRoles[0] = $em->getRepository('TatweerTrainingBundle:Groups')->getGroupRoles($em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId() , NULL);  
                            }
                            else
                            {
                            $groupRoles[$v['groupid']] = $em->getRepository('TatweerTrainingBundle:Groups')->getGroupRoles($em->getRepository('TatweerTrainingBundle:Users')->CurrentLoggedInUserId() , $v['groupid']);
                            }
                        }

       
                        if(isset($groupRoles))
                        {
                        
                        $session->set('roles' , $groupRoles); 
                        }
            }
            else 
            {
               $this->get('session')->getFlashBag()->add('alert-error', $this->get('translator')->trans('Incorrect login data' , array() , 'conformation')); // add flash messages alert-error
               
            }
            return $this->redirect($this->generateUrl('_login'));
        }
        
        
        return $this->render('TatweerTrainingBundle:Default:login.html.twig');
        
    }
   /**
     * logout
     *
     * @Route("/logout", name="_logout")
     * 
     * @Template("TatweerTrainingBundle:Default:index.html.twig")
     */
    public function logoutAction()
    {
        $session = new Session();
        $session->clear();
        return $this->render('TatweerTrainingBundle:Default:index.html.twig');
    }
}
