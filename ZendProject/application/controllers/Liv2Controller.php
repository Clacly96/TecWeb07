<?php

class Liv2Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_formFiltro;
    protected $_formRicerca;
    protected $_authService;
    
    public function init(){
        $this->_helper->layout->setLayout('mainliv2');
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->view->filtroRicerca = $this->getRicercaForm();
        $this->_authService = new Application_Service_Auth();
    }
    
    public function indexAction(){
        $page=$this->_getParam('page',1);
        $pagescont=$this->_getParam('pagescont',1);
        $ultimieventi=$this->_catalogModel->estraiUltimiEventi($page);
        $eventiscontati=$this->_catalogModel->ottieniEventiInSconto($pagescont);
        $this->view->assign(array( 'ultimieventi' => $ultimieventi,
                                    'eventiscontati' => $eventiscontati));
        
    }
    
    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
    public function catalogoAction(){
        $IdEv=$this->_getParam('evento',null);
        $paged = $this->_getParam('page', 1);
        $tiporic=$this->_getParam('tiporic',null);
        if(!is_null($tiporic)){
            if($tiporic=='filtro'){
                if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
                }
                $form=$this->_formFiltro;
               if (!$form->isValid($_POST)) {
                       //return $this->render('catalogo');
                }

                $valori=$form->getValues();
                $eventi= $this->_catalogModel->filtro($paged,$this->settaNullCondizionale($valori['Username']), $this->settaNullCondizionale($valori['Mese']),$this->settaNullCondizionale($valori['Anno']),$this->settaNullCondizionale($valori['Luogo']),$this->settaNullCondizionale($valori['Tipologia']));

            } else if($tiporic=='ricerca'){
                if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
                $form=$this->_formRicerca;

                if (!$form->isValid($_POST)) {
			return $this->render('ricerca');}

               $valori=$form->getValues();
               $eventi= $this->_catalogModel->ricerca($paged, $this->settaNullCondizionale($valori['Mese']),$this->settaNullCondizionale($valori['Anno']),$this->settaNullCondizionale($valori['Luogo']),$this->settaNullCondizionale($valori['Tipologia']),$this->settaNullCondizionale($valori['Descrizione']) );
            }
                else {$this->_helper->redirector('catalogo','liv2');}
        }else if(!is_null($IdEv)){
            $eventi=$this->_catalogModel->estraiEventoPerId($IdEv);
        }
        else { $eventi=$this->_catalogModel->estraiEventi($paged);}

        $this->view->assign(array('eventi'=>$eventi,'EvSelezionato'=>$IdEv));
    }
    
    public function areaprivataAction(){
        
    }
    
    public function ricercaAction(){
        
    }
    
     public function checkoutAction(){
        $evento=$this->getParam('evento');
        if(is_null($evento)){
            $this->_helper->redirector('index');
        }
        
            $ev=$this->_catalogModel->estraiEventoPerId($evento);
            $this->view->assign(array('evento'=>$ev));
        
    }
    
    
    
     private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }
    
        private function getFiltroForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formFiltro = new Application_Form_Liv1_Filtri_Filtro();
        $this->_formFiltro->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'catalogo',
                'tiporic' => 'filtro'),
                'default',true
                ));
        return $this->_formFiltro;
    }
    private function getRicercaForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formRicerca = new Application_Form_Liv1_Ricerca_Ricerca();
        $this->_formRicerca->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'catalogo',
                'tiporic' => 'ricerca'),
                'default',true
                ));
        return $this->_formRicerca;
    }
    
    
}



