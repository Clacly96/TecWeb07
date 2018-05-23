<?php

class Liv1Controller extends Zend_Controller_Action

{
    protected $_catalogModel;
    protected $_form;
    
    public function init()
    {
       $this->_helper->layout->setLayout('main');
        $this->_catalogModel = new Application_Model_Catalogo();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->view->regForm=$this->getRegForm();
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
        $tiporic=$this->_getParam('tiporic',null);
        if(!is_null($tiporic)){
            if($tiporic=='filtro'){
                if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
                }
                $form=$this->_form;
               if (!$form->isValid($_POST)) {
                       // return $this->render(''); 
                }
               
                $valori=$this->_form->getValues();
                $eventi= $this->_catalogModel->filtro($paged,($valori['Username']!=' ')?$valori['Username']: null, null,($valori['Luogo']!=' ')?$valori['Luogo']: null,($valori['Tipologia']!=' ')?$valori['Tipologia']: null ); 
                
            } else if($tiporic=='ricerca'){
                //paolo metti il codice relativo alla ricerca qua
            }
                else $this->_helper->redirector('catalogo','liv1');   
        }else if(!is_null($IdEv)){
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
    private function getFiltroForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Liv1_Filtri_Filtro();
        $this->_form->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'catalogo',
                                'tiporic' => 'filtro'),
                'default'
                ));
        return $this->_form;
    }
    
    private function getRegForm() 
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Liv1_Accesso_Add();
        $this->_form->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'vistastatica',
                'pagina' => 'registrazione'),
                'default',true
                ));
        return $this->_form;
    }
}

