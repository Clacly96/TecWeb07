<?php

class Liv1Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    
    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->_utenzaModel = new Application_Model_Utenza();
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
    }
    public function ricercaAction()
    {
    }
    public function listaorganizzazioniAction()
    {
        $OrgId=$this->_getParam('organizzazione',null);
        $paged = $this->_getParam('page',1);
        if(is_null($OrgId)){
            $org=$this->_utenzaModel->getOrg($paged);
        } else { 
            $org=$this->_utenzaModel->getUtenteByUsername($OrgId);
        }
        $this->view->assign(array(
                        'organizzazioni'=>$org, 
                        'selectedOrg'=>$OrgId
                        )
        );
    }
    public function faqAction(){
        
    }
}

