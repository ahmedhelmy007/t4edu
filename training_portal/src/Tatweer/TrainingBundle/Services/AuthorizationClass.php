<?php

namespace Tatweer\TrainingBundle\Services;
use Symfony\Component\HttpFoundation\Session\Session;
 

class AuthorizationClass
{
  
    private $session;
    
    public function __construct($session)
    {
        $this->session = $session;
        
    }

    public function isLoggedIn()
    {
       
        if($this->session->get('validated'))
            return true;
        
        return false;
    }
    
    public function canView($roleId)
    {
     //   return "ggg";
    }
    
    public function canManage($roleId)
    {
        
      if($this->isLoggedIn())  
      {
        if($userGroupRoles = $this->session->get('roles'))
        {
             
        foreach ($userGroupRoles as $k => $v )
        if(in_array($roleId, $v) )
                return true;
        }
        
        return false;
        
      }
      
      return false;
        
    }
    
    
    
    public function isSuperAdmin()
    {
      if($this->isLoggedIn())  
      {
       if($this->session->get('roles'))
           return false;
       else
           return true;
      }
      
      return false;

    }
    
}