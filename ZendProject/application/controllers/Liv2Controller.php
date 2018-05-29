<?php

class Liv2Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_authService;
    protected $_formTastoacquisto;
    protected $_formAcquisto;
    
    protected $verifica=true;
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
        $this->view->assign(array('ordini' => $ordini['ordini'],'nomi_eventi' => $ordini['nomieventi']));
    }
    public function areaprivataAction(){
        
    }
    
    public function stampaordineAction() {
        $this->_helper->layout->disableLayout();
        $numordine=$this->getParam('ordine');
        $ordine= $this->_utenzaModel->estraiOrdinePerNumero($numordine);
        $evento=$this->_catalogModel->estraiEventoPerId($ordine->Evento);
        $this->view->assign(array('ordine'=>$ordine,'evento'=>$evento));
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
        
            $ev=$this->_catalogModel->estraiEventoPerId($valori['Evento']);
            $this->view->assign(array('evento'=>$ev));
            if ($this->verifica){$this->view->formAcquisto=$this->getFormAcquisto($ev['Id']);} //serve per passare l'id dell'evento all'altro form così da poterlo usare nel campo hidden
            
            
    }
    
    public function completacheckoutAction(){ //ho creato anche sopra la _formAcquisto, il problema è che in questo modo id evento va a null e non so come fare
        if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
                $this->view->formAcquisto=$this->getFormAcquisto();
                $form=$this->_formAcquisto;
                if (!$form->isValid($_POST)) {
                    return $this->render('checkout');} //non deve renderizzare la pagina index, ma dovrebbe renderizzare la pagina dell'evento da cui è stato premuto il tasto acquista
               
               $valori=$form->getValues();
        
            $user=$this->view->authInfo('Username');
            $ev=$this->_catalogModel->estraiEventoPerId($valori['Evento']);
            $bigliettiRim=$ev->Biglietti_Rimanenti;
            if($valori['Numero_Biglietti']>$bigliettiRim){
                $form->setDescription('Attenzione: Il numero di biglietti è superiore ai biglietti rimanenti; Inserire un numero minore di '.$bigliettiRim);
                return $this->render('checkout');
            }
            else{
                $this->_catalogModel->insertOrdine($user,$valori);
                $this->_helper->redirector('storico');
            }              
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
        $this->_formTastoacquisto->addElement('hidden', 'Evento', array(
                        'required' => false,
                        'value' => $IdEv,
                ));
        return $this->_formTastoacquisto;
    }
    
    private function getFormAcquisto($IdEv=null)
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formAcquisto = new Application_Form_Liv2_Acquisto_FormAcquisto(); 
        $this->_formAcquisto->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'completacheckout',),
                'default',true
                ));
        $this->_formAcquisto->addElement('hidden', 'Evento', array(
                        'required' => false,
                        'value' => $IdEv,
                        
                ));
        return $this->_formAcquisto;
    }
   
    
    
    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }

    
}



