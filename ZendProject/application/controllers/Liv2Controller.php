<?php

class Liv2Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_authService;
    protected $_formTastoacquisto;
    
    public function init(){
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->_authService = new Application_Service_Autenticazione();
        $this->view->tastoacquistoForm=$this->getTastoacquistoForm($IdEv=null);
    }
    
    public function indexAction(){
        $this->_helper->redirector('index','liv1');        
    }
    
    public function logoutAction()
    {
		$this->_authService->clear();
		return $this->_helper->redirector('index','liv1');	
    }
    public function storicoAction(){
        $paged = $this->_getParam('page', 1);
        $utente=$this->view->AuthInfo('Username');
        $ordini=$this->_utenzaModel->estraiOrdiniPerUtente($paged,$utente);
        $this->view->assign(array('ordini' => $ordini));
    }
    public function areaprivataAction(){
        
    }
    
    public function checkoutAction()
    {
        if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
                $form=$this->_formTastoacquisto;
                if (!$form->isValid($_POST)) {
			return $this->render('index');} //non deve renderizzare la pagina index, ma dovrebbe renderizzare la pagina dell'evento da cui è stato premuto il tasto acquista
               $valori=$form->getValues();
        
            $ev=$this->_catalogModel->estraiEventoPerId($valori['evento']);
            $this->view->assign(array('evento'=>$ev));
        
    }
    
    private function getTastoacquistoForm($IdEv=null)
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formTastoacquisto = new Application_Form_Liv2_Acquisto_Tastoacquisto(); 
        $this->_formTastoacquisto->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'checkout',),
                'default',true
                ));
        //l'ho messo qui l'elemento hidden perchè ho provato a passare un parametro alla form, ma non lo riceve e non capisco perchè
        $this->_formTastoacquisto->addElement('hidden', 'evento', array(
                        'required' => false,
                        'value' => $IdEv,
                ));
        return $this->_formTastoacquisto;
    }
    
    
    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }

    
}



