<?php

class Application_Service_Autenticazione
{
    protected $_utenzaModel;
    protected $_auth;

    public function __construct()
    {
        $this->_utenzaModel = new Application_Model_Utenza();
    }
    
    public function autenticato($credenziali)
    {
        $adapter = $this->getAuthAdapter($credenziali);
        $auth    = $this->getAuth();
        $result  = $auth->autenticato($adapter);

        if (!$result->isValid()) {
            return false;
        }
        $user = $this->_utenzaModel->getUtenteByUsername($credenziali['Username']);
        $auth->getStorage()->write($user);
        return true;
    }
    
    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }
   
    public function getIdentity()
    {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }
    
    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }
    
    private function getAuthAdapter($values)
    {
	$authAdapter = new Zend_Auth_Adapter_DbTable(
		Zend_Db_Table_Abstract::getDefaultAdapter(),
		'utente',
		'Username',
		'Password'
	);
	$authAdapter->setIdentity($values['Username']);
	$authAdapter->setCredential($values['Password']);
        return $authAdapter;
    }
}

