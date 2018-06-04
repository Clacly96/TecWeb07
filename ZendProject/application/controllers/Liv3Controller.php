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
        
        $ultimoId=$this->_catalogModel->estraiUltimoId();
        if($ultimoId==null){
            $IdEv=0;
        }
        else{
            $IdEv=$ultimoId+1;
        }
        
        $estensione = pathinfo($form->getElement('Locandina')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Locandina')->addFilter('Rename', array(
            'target' => $IdEv . '.' . $estensione,
            'overwrite' => true
            ));
      
        $valori=$form->getValues();
        if ($valori['Sconto']==null){$valori['Sconto']=0;}
        if ($valori['Giorni_Sconto']==null){$valori['Giorni_Sconto']=0;}
        if ($valori['Locandina']==null){$valori['Locandina']='noimage.jpg';}
        $valori['IdEv']=$IdEv;
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
        $this->view->assign(array('idevento'=>$IdEv));
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
        
        $estensione = pathinfo($form->getElement('Locandina')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Locandina')->addFilter('Rename', array(
            'target' => $IdEv . '.' . $estensione,
            'overwrite' => true
            ));
        
        $valori=$form->getValues();
        if($valori['elimina_locandina']){$valori['Locandina']='noimage.jpg';}
        else if($valori['Locandina']==null){             //se non viene inserita una nuova locandina, viene reinserita la vecchia
            $valori['Locandina']=$evento->Locandina;
        }
        
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

