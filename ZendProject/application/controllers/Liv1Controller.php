<?php

class Liv1Controller extends Zend_Controller_Action

{
    protected $_catalogModel;
    protected $_form;
    protected $_form2; 
    
    public function init()
    {
       $this->_helper->layout->setLayout('main');
        $this->_catalogModel = new Application_Model_Catalogo();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->view->filtroRicerca = $this->getRicercaForm();
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
                
                
            } else if($tiporic=='ricerca'){
                
               if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');}
                        
               $form=$this->_form2;
               if (!$form->isValid($_POST)) {    
			return $this->render('ricerca');}
               
               $valori=$this->_form2->getValues();
               $eventi= $this->_catalogModel->ricerca($paged, null,($valori['Luogo']!=' ')?$valori['Luogo']: null,($valori['Tipologia']!=' ')?$valori['Tipologia']: null, ($valori['Descrizione']!=' ')?$valori['Descrizione']: null );
               
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
     private function getRicercaForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form2 = new Application_Form_Liv1_Ricerca_Ricerca();
        $this->_form2->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'catalogo',
                                'tiporic' => 'ricerca'),
                'default'
                ));
        return $this->_form2;
    }
}

