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
    

    public function getUtenteByUsername($username)
    {
        return $this->getResource('Utente')->getUtenteByUsername($username);

    }
	
    public function getUtenti() {
        return $this->getResource('Utente')->getUtenti();
        
    }
    
    public function getEmails() {
        return $this->getResource('Utente')->getEmails();
    }

    public function getTelefoni() {
        return $this->getResource('Utente')->getTelefoni();
    }
    
    public function insertUtente($info) {
        return $this->getResource('Utente')->insertUtente($info);
    }
}

