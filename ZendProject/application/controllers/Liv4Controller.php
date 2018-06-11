<?php
class Liv4Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_authService;
    protected $_formModifica;
    protected $_formInserisci;
    protected $_formModificaorg;
    
    public function init() {
        $this->_helper->layout->setLayout('main');
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->_authService = new Application_Service_Autenticazione();
        $this->view->inserisciForm= $this->getInserisciForm();
    }
    
    public function indexAction() {
        $this->_helper->redirector('index','liv1');
    }
    
    public function logoutAction() {
        $this->_authService->clear();
	return $this->_helper->redirector('index','liv1');
    }
    
    public function areaprivataAction() {
        
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
        
    }
    
    public function insertorganizzazioneAction() {
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('listaorganizzazioni');
        }
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
            'target' => $OrgId . '.' . $estensione,
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
