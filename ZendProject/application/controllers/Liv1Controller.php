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
                //paolo metti il codice relativo alla ricerca qua
                $form=$this->_form2;
                if (!$form->isValid($_POST)) {    //a quel che ho capito la valid è necessaria anche se non si deve fare una validazione
			return $this->render('ricerca');
		}
                $desc = $form->getValue('Descrizione');
                $luogo = $form->getValue('Luogo');
                $data = $form->getValue('Data_Ora');
                $tipo = $form->getValue('Categoria');
                if($desc=='')
                {
                    $desc=null;
                }
                  if($luogo=='')
                {
                    $luogo=null;
                }
                  if($data=='')
                {
                    $cat=null;
                }
                  if($tipo=='')
                {
                    $tipo=null;
                }
             
                $eventi=$this->_catalogModel->ricerca($paged,$data,$luogo,$tipo,$desc);  //quando si lascia vuota il campo di una form non si ha un valore null, se invece faccio la ricerca mettendo manualmente null, il tutto funziona
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

