<?php

class Liv1Controller extends Zend_Controller_Action
{
<<<<<<< HEAD
    protected $_faqModel;
    protected $_catalogModel;
    protected $_utenzaModel;
    protected $_formFiltro;
    protected $_formRicerca;
    protected $_formLogin;
    
    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->_faqModel=new Application_Model_Faq;
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->view->filtroRicerca = $this->getRicercaForm();
        $this->view->formLogin = $this->getLoginForm();

    }
    public function indexAction()
    {
        $page=$this->_getParam('page',1);
        $pagescont=$this->_getParam('pagescont',1);
        $ultimieventi=$this->_catalogModel->estraiUltimiEventi($page);
        $eventiscontati=$this->_catalogModel->ottieniEventiInSconto($pagescont);
        $this->view->assign(array( 'ultimieventi' => $ultimieventi,
                                    'eventiscontati' => $eventiscontati));
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
                else {$this->_helper->redirector('catalogo','liv1');}   
        }else if(!is_null($IdEv)){
            $eventi=$this->_catalogModel->estraiEventoPerId($IdEv);
        }
        else { $eventi=$this->_catalogModel->estraiEventi($paged);}
        
        $this->view->assign(array('eventi'=>$eventi,'EvSelezionato'=>$IdEv));
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
        $page=$this->_getParam('page',1);
        $listafaq= $this->_faqModel->estraiFaq($page);
        $this->view->assign(array('listafaq'=>$listafaq));
    }
    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }
    private function getFiltroForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formFiltro = new Application_Form_Liv1_Filtri_Filtro();
        $this->_formFiltro->setAction($urlHelper->url(array(
                'controller' => 'liv1',
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
                'controller' => 'liv1',
                'action' => 'catalogo',
                'tiporic' => 'ricerca'),
                'default',true
                ));
        return $this->_formRicerca;
    }
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formLogin = new Application_Form_Liv1_Utenza_Login();
        $this->_formLogin->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'index',),
                'default',true
                ));
        return $this->_formLogin;
    }
}

