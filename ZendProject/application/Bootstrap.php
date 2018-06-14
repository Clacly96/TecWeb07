<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_view;
    protected $_logger;
/*
 protected function _initLogging()
    {
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/data/log/logFile.log');        
        $logger = new Zend_Log($writer);

        Zend_Registry::set('log', $logger);

        $this->_logger = $logger;
    	$this->_logger->info('Bootstrap ' . __METHOD__);
    }*/
    
protected function _initRequest()
	// Aggiunge un'istanza di Zend_Controller_Request_Http nel Front_Controller
	// che permette di utilizzare l'helper baseUrl() nel Bootstrap.php
	// Necessario solo se la Document-root di Apache non è la cartella public/
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }
protected function _initViewSettings()
    {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->setCharset('UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
	$this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));
        $this->_view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js')->appendFile($this->_view->baseUrl('js/script.js'),'text/javascript');
        $this->_view->headTitle('Timple');
    }
    protected function _initDefaultModuleAutoloader()
    {
    	$loader = Zend_Loader_Autoloader::getInstance();
		$loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');
  	}
    protected function _initFrontControllerPlugin()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$front->registerPlugin(new App_Controller_Plugin_Acl());
    }
    protected function _initDbParms()
    {
        include_once (APPLICATION_PATH . '/../../include/connect.php');
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
                'host'     => $HOST,
                'username' => $USER,
                'password' => $PASSWORD,
                'dbname'   => $DB,
                'charset'  => "utf8"
                ));  
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
}

