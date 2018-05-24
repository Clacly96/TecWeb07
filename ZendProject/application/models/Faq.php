<?php
class Application_Model_Faq extends App_Model_Abstract
{ 

	public function __construct()
    {
		//$this->_logger = Zend_Registry::get('log');  	
	}
        
        public function estraiFaqPerId($Id)
        {
            return $this->getResource('Faq')->estraiFaqPerId($Id);
            
        }
        
        public function estraiFaq($paged=null)
        {
            return $this->getResource('Faq')->estraiFaq($paged);
        }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

