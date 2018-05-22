<?php
class Application_Model_Utenza extends App_Model_Abstract
{ 
	public function __construct()
    {
	//$this->_logger = Zend_Registry::get('log');  	
    }
   
    public function getOrg($paged=null)
    {     
        return $this->getResource('Utente')->getOrg($paged);
    }    
    
    public function getOrgById($id)
    {
        return $this->getResource('Utente')->getOrgById($id);
    }
}


