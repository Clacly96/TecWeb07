<?php

class Liv3Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_authService;
    protected $_formInserimentoEvento;
    protected $_formModificaEvento;
    protected $_flashMessenger = null;

    public function init() {
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->_authService = new Application_Service_Autenticazione();
        $this->_flashMessenger =$this->_helper->getHelper('FlashMessenger');
    }
    public function indexAction(){
        $this->_helper->redirector('index','liv1');
    }

    
    public function logoutAction()
    {
		$this->_authService->clear();
		return $this->_helper->redirector('index','liv1');
    }
    
    public function areaprivataAction(){
        if(!is_null($this->_flashMessenger->getMessages())){
            $this->view->messages = $this->_flashMessenger->getMessages();
        }
        $loc=$this->_catalogModel->estraiLocandine();
        $this->view->assign(array('locandine'=>$loc));
    }
    
    
    public function inserimentoAction(){        
        $this->view->formInserimento = $this->getFormInserimentoEvento();
    }
    
    
    public function inseriscieventoAction(){
        $this->view->formInserimento = $this->getFormInserimentoEvento();
        if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
        }
        
        $form=$this->_formInserimentoEvento;
        if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
                       return $this->render('inserimento');
        }
        
        $loc=$this->_catalogModel->estraiLocandine();
        if(count($loc)==0){
            $nomeNuovaLocandina=0;
        }
        foreach ($loc as $locandina) {
            $nomilocandine[]=pathinfo($locandina->Locandina, PATHINFO_FILENAME); //estrae il nome della locandina senza estensione
        }
        $nomeNuovaLocandina= max($nomilocandine)+1;
        
        $estensione = pathinfo($form->getElement('Locandina')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Locandina')->addFilter('Rename', array(
            'target' => $nomeNuovaLocandina . '.' . $estensione,
            'overwrite' => true
            ));
      
        $valori=$form->getValues();
        $valori['Organizzazione']=$this->view->AuthInfo('Username');
        $this->_catalogModel->inserisciEvento($valori);
        $this->_flashMessenger->addMessage('Evento inserito con successo!');
        $this->_helper->redirector('areaprivata');
    }
    
    
    public function modificaAction(){
        if(is_null($this->_getParam('evento'))){
            $this->_helper->redirector('index');
        }
        
        $IdEv=$this->_getParam('evento');
        $organizzazione=$this->view->AuthInfo('Username');
        $evento=$this->_catalogModel->estraiEventoPerId($IdEv);
        if($evento->Organizzazione !== $organizzazione){
            $this->_helper->redirector('index');
        }
        $this->view->formModifica = $this->getFormModificaEvento($IdEv);
    }
    
    
    public function modificaeventoAction(){        
        if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
        }
        
        if(is_null($this->_getParam('evento'))){
            $this->_helper->redirector('index');
        }
        $IdEv=$this->_getParam('evento');
        
        $organizzazione=$this->view->AuthInfo('Username');
        $evento=$this->_catalogModel->estraiEventoPerId($IdEv);
        
        $this->view->formModifica = $this->getFormModificaEvento($IdEv);
        if($evento->Organizzazione !== $organizzazione){
            $this->_helper->redirector('index');
        }
       
        $form=$this->_formModificaEvento;
        if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
                       return $this->render('modifica');
        }
        $nomeLocandina=pathinfo($evento->Locandina, PATHINFO_FILENAME);
        $estensione = pathinfo($form->getElement('Locandina')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Locandina')->addFilter('Rename', array(
            'target' => $nomeLocandina . '.' . $estensione,
            'overwrite' => true
            ));
        
        $valori=$form->getValues();
        $valori['Organizzazione']=$organizzazione;       
        $valori['Id']=$IdEv;
        
        $this->_catalogModel->modificaEvento($valori);
        $this->_flashMessenger->addMessage('Evento modificato con successo!');
        $this->_helper->redirector('areaprivata');
    }
    public function cancellaAction() {
        if(!is_null($this->_getParam('evento'))){
            $IdEv=$this->_getParam('evento');
        } else {
            $this->_helper->redirector('index');
        }
        $organizzazione=$this->view->AuthInfo('Username');
        $evento=$this->_catalogModel->estraiEventoPerId($IdEv);
        if($evento->Organizzazione !== $organizzazione){
            $this->_helper->redirector('index');
        }
        
        $this->_catalogModel->cancellaEvento($IdEv);
        $this->_flashMessenger->addMessage('Evento eliminato con successo!');
        $this->_helper->redirector('areaprivata');
    }
    
    public function listaeventiAction() {
        $page=$this->_getParam('page',1);
        $organizzazione=$this->view->AuthInfo('Username');
        $eventi=$this->_catalogModel->estraiEventiPerOrganizzazione($page,$organizzazione);
        $this->view->assign(array('eventi' => $eventi));
    }
    
    
    
    /*************************Inizio funzioni getform***********************************/
    private function getFormInserimentoEvento()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formInserimentoEvento = new Application_Form_Liv3_Eventi_Inserimento();        
        $this->_formInserimentoEvento->setAction($urlHelper->url(array(
                'controller' => 'liv3',
                'action' => 'inseriscievento',
                ),
                'default',true
                ));
        return $this->_formInserimentoEvento;
    }
    private function getFormModificaEvento($IdEv=null)
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formModificaEvento = new Application_Form_Liv3_Eventi_Modifica(array('evento'=>$IdEv));        
        
        $this->_formModificaEvento->setAction($urlHelper->url(array(
                'controller' => 'liv3',
                'action' => 'modificaevento',
                'evento' => $IdEv,
                ),
                'default',true
                ));
        return $this->_formModificaEvento;
    }
}

