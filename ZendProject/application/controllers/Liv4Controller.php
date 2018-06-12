<?php

class Liv4Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_faqModel;
    protected $_authService;
	
    protected $_formInserimentoTipologia;
    protected $_formModificaTipologia;
    protected $_formInserimentoFaq;
    protected $_formModificaFaq;
    protected $_formModifica;
    protected $_formInserisci;
    protected $_formModificaorg;
	
    protected $_flashMessenger = null;
   

    public function init() {
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
		$this->_utenzaModel = new Application_Model_Utenza();
         $this->_faqModel=new Application_Model_Faq();
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
	
    public function listaorganizzazioniAction() {
        $OrgId=$this->_getParam('organizzazione',null);
        $paged = $this->_getParam('page',1);
        if(is_null($OrgId)){
            $organizzazioni=$this->_utenzaModel->getListaOrganizzazioni($paged);
        } else {
            $organizzazioni=$this->_utenzaModel->getUtenteByUsername($OrgId);
        }
        $this->view->assign(array(
                        'organizzazioni'=>$organizzazioni,
                        'selectedOrg'=>$OrgId
                        )
        );
    }
    
    public function listautentiAction() {
        $UteId=$this->_getParam('utente',null);
        $paged = $this->_getParam('page',1);
        if(is_null($UteId)){
            $utente=$this->_utenzaModel->getListaUtenti($paged);
        } else {
            $utente=$this->_utenzaModel->getUtenteByUsername($UteId);
            $ordini=$this->_utenzaModel->estraiOrdiniPerUtente($paged=null,$UteId);
            $this->view->assign(array('ordini' => $ordini['ordini'],'nomi_eventi' => $ordini['nomieventi']));
        }
        $this->view->assign(array(
                        'utenti'=>$utente,
                        'selectedUte'=>$UteId
                        )
        );
    }
    
    public function inserisciorganizzazioneAction() {
        $this->view->inserisciForm= $this->getInserisciForm();
    }
    
    public function insertorganizzazioneAction() {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('listaorganizzazioni');
        }
		$this->view->inserisciForm= $this->getInserisciForm();
        $form=$this->_formInserisci;
        if (!$form->isValid($_POST)) {
	    $form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
            return $this->render('inserisciorganizzazione');
        }
        $estensione = pathinfo($form->getElement('Logo')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Logo')->addFilter('Rename', array(
            'target' => $form->getElement('Username')->getValue() . '.' . $estensione,
            'overwrite' => true
        ));
        $valori=$form->getValues();
        if($valori['Logo']==null){
            $valori['Logo']='noimage.jpg';
        }
        $this->_utenzaModel->insertOrganizzazione($valori);
        $this->_helper->redirector('listaorganizzazioni');
        
    }
    
    public function modificautenteAction() {
        
        $Uteusername=$this->_getParam('utente', null);
        if(is_null($Uteusername)) {
            $this->_helper->redirector('listautenti');
        }
        $this->view->modificaForm = $this->getModificaForm($Uteusername);
        $this->view->assign(array(
                        'utente' => $Uteusername
                        )
        );
        
    }
    
    public function updateutenteAction() {
        $username=$this->_getParam('utente', null);
        if(is_null($username)){
            $this->_helper->redirector('listautenti');
        }
        $this->view->modificaForm= $this->getModificaForm($username);
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('listautenti');
        }
        $form=$this->_formModifica;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
            return $this->render('modificautente');
        }
        $valori=$form->getValues();
        $ute=$this->_utenzaModel->getUtenteByUsername($username);
        if($valori['Password']==null){
            $valori['Password']=$ute->Password;
        }
        $oldusername=$ute->Username;
        $this->_utenzaModel->updateUtente($valori,$oldusername);
        $this->_helper->redirector('listautenti');
    }
    
    public function modificaorganizzazioneAction() {
        $OrgId=$this->_getParam('organizzazione', null);
        if(is_null($OrgId)) {
            $this->_helper->redirector('listaorganizzazioni');
        }
        $this->view->modificaorgForm = $this->getModificaorgForm($OrgId);
        $this->view->assign(array(
                        'utente' => $OrgId
                        )
        );
    }
    
    public function updateorganizzazioneAction() {
        $OrgId=$this->_getParam('organizzazione', null);
        if(is_null($OrgId)){
            $this->_helper->redirector('listaorganizzazioni');
        }
        $this->view->modificaorgForm= $this->getModificaorgForm($OrgId);
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('listaorganizzazioni');
        }
        $form=$this->_formModificaorg;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
            return $this->render('modificaorganizzazione');
        }
        $estensione = pathinfo($form->getElement('Logo')->getFileName(), PATHINFO_EXTENSION); 
        $form->getElement('Logo')->addFilter('Rename', array(
            'target' => $form->getElement('Username')->getValue() . '.' . $estensione,
            'overwrite' => true
        ));
        $valori=$form->getValues();
        $organiz=$this->_utenzaModel->getUtenteByUsername($OrgId);
        if($valori['Logo']==null){
            $valori['Logo']=$organiz->Logo;
        }
        if($valori['Password']==null){
            $valori['Password']=$organiz->Password;
        }
        $oldusername=$organiz->Username;
        $this->_utenzaModel->updateOrganizzazione($valori,$oldusername);
        $this->_helper->redirector('listaorganizzazioni');
    }
    
    public function cancellautenteAction() {
        if(!is_null($this->_getParam('utente'))){
            $UteId=$this->_getParam('utente');
        } else {
            $this->_helper->redirector('listautenti');
        }
        $this->_utenzaModel->cancellaUtente($UteId);
        $this->_helper->redirector('listautenti');
    }
    
    public function cancellaorganizzazioneAction() {
        if(!is_null($this->_getParam('organizzazione'))){
            $OrgId=$this->_getParam('organizzazione');
        } else {
            $this->_helper->redirector('listaorganizzazioni');
        }
        $this->_utenzaModel->cancellaOrganizzazione($OrgId);
        $this->_helper->redirector('listaorganizzazioni');
    }
    
    public function areaprivataAction(){
       if(!is_null($this->_flashMessenger->getMessages())){
            $this->view->messages = $this->_flashMessenger->getMessages();}
        }
        
    public function gestionetipoAction(){
        
        $tipologie=$this->_catalogModel->estraiCategorie();
        $this->view->assign(array('tipologie' => $tipologie));
       
    }
    
    public function instipologiaAction(){
        $this->view->formInserimento = $this->getFormInserimentoTipologia();
    }
    
    public function inseriscitipologiaAction(){
        $this->view->formInserimento = $this->getFormInserimentoTipologia();
        if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
	$form=$this->_formInserimentoTipologia;
        if (!$form->isValid($_POST)) {
                        $form->setDescription('Attenzione: tipologia già esistente');
                        return $this->render('gestionetipo');
        }
        $valori=$form->getValues();
        $this->_catalogModel->insertTipologia($valori);
        $this->_flashMessenger->addMessage('Tipologia inserita con successo!');
        $this->_helper->redirector('areaprivata');
    }
    
    public function cancellatipologiaAction(){
        if(!is_null($this->_getParam('tipo'))){
            $tipo=$this->_getParam('tipo');
        } else {
            $this->_helper->redirector('index');
        }
        
        $this->_catalogModel->cancellazioneTipologia($tipo);
        $this->_flashMessenger->addMessage('Tipologia eliminata con successo!');
        $this->_helper->redirector('areaprivata');
        
    }
    
    public function modificatipoAction(){
        if(!is_null($this->_getParam('tipo'))){
            $tipo=$this->_getParam('tipo');
        } else {
            $this->_helper->redirector('index');
        }
        $this->view->formModifica = $this->getFormModificaTipologia($tipo);
    }
    
    public function modificatipologiaAction(){
        
         if(!is_null($this->_getParam('tipo'))){
            $vecchio=$this->_getParam('tipo');
        } else {
            $this->_helper->redirector('index');
        }
        $this->view->formModifica = $this->getFormModificaTipologia($vecchio);
        if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
	$form=$this->_formModificaTipologia;
        if (!$form->isValid($_POST)) {
             $form->setDescription('Attenzione: nome tipologia gia utilizzato.');
             return $this->render('modificatipo');
        }
        $nuovo=$form->getValues();
      
        $this->_catalogModel->modificaTipologia($vecchio,$nuovo['Nome']);
        $this->_flashMessenger->addMessage('Tipologia modificata con successo!');
        $this->_helper->redirector('areaprivata');
          
    }
    
    
    
    public function gestionefaqAction(){
        $page=$this->_getParam('page',1);
        $listafaq= $this->_faqModel->estraiFaq($page);
        $this->view->assign(array('listafaq'=>$listafaq));
        
        
    }
    
    public function insfaqAction(){
        $this->view->formInserimento = $this->getFormInserimentoFaq();
    }
    
    public function inseriscifaqAction(){
         $this->view->formInserimento = $this->getFormInserimentoFaq();
        if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
	$form=$this->_formInserimentoFaq;
        if (!$form->isValid($_POST)) {
                        $form->setDescription('Attenzione: controlla i dati immessi');
                        return $this->render('gestionefaq');
        }
        $valori=$form->getValues();
         $this->_faqModel->insertFaq($valori);
        $this->_flashMessenger->addMessage('Faq inserita con successo!');
        $this->_helper->redirector('areaprivata');
        
    }
    
    public function cancellafaqAction(){
          if(!is_null($this->_getParam('faq'))){
            $IdFaq=$this->_getParam('faq');
        } else {
            $this->_helper->redirector('index');
        }
         $this->_faqModel->cancellazioneFaqPerId($IdFaq);
        $this->_flashMessenger->addMessage('Faq eliminata con successo!');
        $this->_helper->redirector('areaprivata');
        
        
    }
    
    public function modfaqAction(){
         if(!is_null($this->_getParam('faq'))){
            $IdFaq=$this->_getParam('faq');
        } else {
            $this->_helper->redirector('index');
        }
        $this->view->formModifica = $this->getFormModificaFaq($IdFaq);
        
    }
    public function modificafaqAction(){
         if(!is_null($this->_getParam('faq'))){
            $IdFaq=$this->_getParam('faq');
        } else {
            $this->_helper->redirector('index');
        }
        $this->view->formModifica = $this->getFormModificaFaq($IdFaq);
         if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
	$form=$this->_formModificaFaq;
        if (!$form->isValid($_POST)) {
             $form->setDescription('Attenzione: verifica i dati immessi.');
             return $this->render('modfaq');
        }
        $valori=$form->getValues();
        $this->_faqModel->modificaFaqPerId($IdFaq, $valori);
        $this->_flashMessenger->addMessage('Faq modificata con successo!');
        $this->_helper->redirector('areaprivata');
        
    }
    
    public function validazioneformAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        $form;
        $nomeForm=$this->_getParam('form');
        switch ($nomeForm) {
            case 'insfaq':
                $form = new Application_Form_Liv4_Faq_Inserimento();
                break;
            case 'modfaq':
                $IdFaq=$this->_getParam('faq');
                $form = new Application_Form_Liv4_Faq_Modifica(array('faq'=>$IdFaq));
                break;
            case 'insorg':
                $form = new Application_Form_Liv4_Inserisci_FormInserisciorganizzazione();
                break;
            case 'modorg':
                $OrgId=$this->_getParam('organizzazione');
                $form = new Application_Form_Liv4_Modifica_FormModificaorganizzazione(array('organizzazione'=>$OrgId));
                break;
            case 'modutente':
                $username=$this->_getParam('utente', null);
                $form = new Application_Form_Liv4_Modifica_FormModificautente(array('utente'=>$username));
                break;
            case 'instipo':
                $form = new Application_Form_Liv4_Tipologie_Inserimento();
                break;
            case 'modtipo':
                $tipo=$this->_getParam('tipo');
                $form = new Application_Form_Liv4_Inserisci_Modifica(array('tipo'=>$tipo));
                break;
        }
        
        $response = $form->processAjax($_POST); 
        if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
          
    // inizio metodi per le form
    
      private function getFormInserimentoTipologia()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formInserimentoTipologia = new Application_Form_Liv4_Tipologie_Inserimento();        
        $this->_formInserimentoTipologia->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'inseriscitipologia',
                ),
                'default',true
                ));
        return $this->_formInserimentoTipologia;
    }
       private function getFormModificaTipologia($tipo)
    {
        $urlHelper = $this->_helper->getHelper('url');
       $this->_formModificaTipologia = new Application_Form_Liv4_Tipologie_Modifica(array('tipo'=>$tipo));      
        $this->_formModificaTipologia->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'modificatipologia',
                'tipo' => $tipo,
                ),
                'default',true
                ));
        return $this->_formModificaTipologia;
    }
    
        private function getFormInserimentoFaq()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formInserimentoFaq = new Application_Form_Liv4_Faq_Inserimento();        
        $this->_formInserimentoFaq->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'inseriscifaq',
                ),
                'default',true
                ));
        return $this->_formInserimentoFaq;
    }
    
          private function getFormModificaFaq($IdFaq)
    {
        $urlHelper = $this->_helper->getHelper('url');
       $this->_formModificaFaq = new Application_Form_Liv4_Faq_Modifica(array('faq'=>$IdFaq));      
        $this->_formModificaFaq->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'modificafaq',
                'faq' => $IdFaq,
                ),
                'default',true
                ));
        return $this->_formModificaFaq;
    }
	
	private function getModificaForm($username=null) {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formModifica = new Application_Form_Liv4_Modifica_FormModificautente(array('utente'=>$username));
        $this->_formModifica->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'updateutente',
                'utente' => $username,
            ),
                'default',true
                ));
        return $this->_formModifica;
    }
    
    private function getInserisciForm() {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formInserisci = new Application_Form_Liv4_Inserisci_FormInserisciorganizzazione();
        $this->_formInserisci->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'insertorganizzazione'),
                'default',true
                ));
        return $this->_formInserisci;
    }
    
    private function getModificaorgForm($OrgId=null) {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formModificaorg = new Application_Form_Liv4_Modifica_FormModificaorganizzazione(array('organizzazione'=>$OrgId));
        $this->_formModificaorg->setAction($urlHelper->url(array(
                'controller' => 'liv4',
                'action' => 'updateorganizzazione',
                'organizzazione' => $OrgId
                ),
                'default',true
                ));
        return $this->_formModificaorg;
    }
	
}