<?php 

class Application_Model_Acl extends Zend_Acl
{
	public function __construct()
	{
		// ACL per utente liv1
		$this->addRole(new Zend_Acl_Role('liv1'))
			 ->add(new Zend_Acl_Resource('liv1'))
			 ->add(new Zend_Acl_Resource('error'))
			 ->add(new Zend_Acl_Resource('index'))
			 ->allow('liv1', array('liv1','error','index'));
			 
		// ACL per utente liv2
		$this->addRole(new Zend_Acl_Role('utente'), 'liv1')
			 ->add(new Zend_Acl_Resource('liv2'))
			 ->allow('utente','liv2')
                         ->deny('utente','liv1',array('login','registrazione'));
               /* 
                // ACL per organizzazione (liv3)
		$this->addRole(new Zend_Acl_Role('liv3'), 'liv2')
			 ->add(new Zend_Acl_Resource('liv3'))
			 ->allow('liv3','liv3');
				   
		// ACL per amministratore (liv4)
		$this->addRole(new Zend_Acl_Role('liv4'), 'liv3')
			 ->add(new Zend_Acl_Resource('liv4'))
			 ->allow('liv4','liv4');*/
	}
}