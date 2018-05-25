<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	protected $_acl;
	protected $_role;
	protected $_auth;

	public function __construct()
	{
        $this->_auth = Zend_Auth::getInstance();
		$this->_role = !$this->_auth->hasIdentity() ? 'liv1' : $this->_auth->getIdentity()->Ruolo;
    		$this->_acl = new Application_Model_Acl();    	
	}

    public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		if (!$this->_acl->isAllowed($this->_role, $request->getControllerName(),$request->getActionName())) {
			$this->_auth->clearIdentity();
			$this->denyAccess();
		}
	}
	
	private function denyAccess()
	{
           $redirector = new Zend_Controller_Action_Helper_Redirector;
           $redirector->gotoSimple('index','liv1');
	}
}
