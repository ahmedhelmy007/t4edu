<?php

namespace Tatweer\TrainingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Security controller.
 * 
 * @Route("/auth")
 */

class SecurityController extends Controller
{
    /**
     * @Route("/login_form", name="login_route")
     * @Template("TatweerTrainingBundle:Security:index.html.twig")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {echo ('if');
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {echo ('elseif');
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {echo ('else');
            $error = null;
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render(
            'TatweerTrainingBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
        
    }
    
    /**
     * @Route("/check", name="login_checker")
     * @Template()
    */
    public function loginCheckAction(Request $request)
    {
        // The security layer will intercept this request
        
        $user= $this->getUser();
//        $user = $this->get('security.context')->getToken()->getUser();
        $response= 'user:<pre>'
                .print_r($request->getSession()->get(SecurityContext::LAST_USERNAME), 1)
                //.print_r($user,1)
                ;
        return new Response($response , 200, array('Content-Type' => 'text/plain'));

    }
    
    
    /**
     * @Route("/index", name="auth_index1")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     * 
     * empty page just to display user authentication info in debug bar
     */
    public function indexAction()
    {
        //if you only want to check if a user is logged in (you don't care about roles)
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        //You can easily deny access from inside a controller using:
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
        
        //All users (even anonymous ones) have this - this is useful when whitelisting URLs to guarantee access
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
            //rest of users (anonymous users or guests)
        }
        
        
        return $this->render('TatweerTrainingBundle:Security:index.html.twig');
    }
}