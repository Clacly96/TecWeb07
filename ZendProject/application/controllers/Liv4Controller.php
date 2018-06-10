<?php

class Liv4Controller extends Zend_Controller_Action
{
   
    protected $_catalogModel;
    protected $_faqModel;
    protected $_authService;
    protected $_formInserimentoTipologia;
    protected $_formModificaTipologia;
    protected $_formInserimentoFaq;
    protected $_formModificaFaq;
    protected $_flashMessenger = null;
   

    public function init() {
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
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
        $this->_catalogModel->setDefaultTipologia($tipo);
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
}
    


