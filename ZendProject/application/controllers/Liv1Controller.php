<?php

class Liv1Controller extends Zend_Controller_Action

{
    protected $_catalogModel;
    
    public function init()
    {
       $this->_helper->layout->setLayout('main');
        $this->_catalogModel = new Application_Model_Catalogo();
    }
    public function indexAction()
    {
    }
    public function vistastaticaAction()
    {
        $page = $this->_getParam('pagina');
        $this->render($page);
    }
    public function catalogoAction()
    {   
       
        $IdEv=$this->_getParam('evento',null);
        $paged = $this->_getParam('page', 1);
        if(!is_null($IdEv)){
            $eventi=$this->_catalogModel->estraiEventoPerId($IdEv);
        }
        else { $eventi=$this->_catalogModel->estraiEventi($paged);}
        
        $this->view->assign(array('eventi'=>$eventi,'EvSelezionato'=>$IdEv));
            
  }
    public function ricercaAction()
    {
    }
   
    public function faqAction(){
        
        
        
    }
}

