<?php

namespace Tatweer\TrainingBundle\Services;

class ActiveDirectoryClass
{

    public function __construct()
    {
    }

       
    public function getUserResults($form_data)
    {
        $data = array();
        
        if(!empty($form_data['username']))
        {
        $data['userName'] = $form_data['username'];
        }
        
        if(!empty($form_data['employee_no']))
        {
        $data['employeeNo'] = $form_data['employee_no'];
        }
        
        if(!empty($form_data['ar_fullname']))
        {
        $data['nameAr'] = $form_data['ar_fullname'];
        }
        
        if(!empty($form_data['en_fullname']))
        {
        $data['nameEn'] = $form_data['en_fullname'];
        }
        
        $soapClient = null;
        // SOAP client
        $wsdl = 'http://dev-ws-srv/T4eduService/T4eduService.svc?wsdl';
        $soapClient = new \SoapClient($wsdl, array('cache_wsdl' => 0));
        $parameters = new \stdClass();
        
        try
        {
        //SEARCH FOR USERS IN ACTIVE DRIECTORY

        $parameters->userName = (isset($data['userName']) ? $data['userName'] : "");
        $parameters->employeeNo = (isset($data['employeeNo']) ? $data['employeeNo'] : "");
        $parameters->nameAr = (isset($data['nameAr']) ? $data['nameAr'] : "");
        $parameters->nameEn = (isset($data['nameEn']) ? $data['nameEn'] : "");

        
        $parameters->userType = "T4edu";
        $parameters->serviceKey = "1no42y=0mt6395R";
        $result = $soapClient->GetUserByKeys($parameters);

        } 
        catch (SoapFault $fault)
        {
	echo "Fault code: {$fault->faultcode}" . NEWLINE;
	echo "Fault string: {$fault->faultstring}" . NEWLINE;
	if ($soapClient != null)
	{
	$soapClient = null;
	}
	exit();
        }
        $soapClient = null;
        
        if($result->GetUserByKeysResult)
        {
            return  $result->GetUserByKeysResult->UserInfo;
        }
        
        return null;
    }
    
}