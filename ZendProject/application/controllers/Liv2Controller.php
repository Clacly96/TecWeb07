<?php

class Liv2Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_authService;
    protected $_formAcquisto;


    protected $_formModifica;

    public function init(){
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->_authService = new Application_Service_Autenticazione();

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

    public function modificadatiutenteAction() {
        $this->view->modForm=$this->getModForm();
    }
    
    public function validazionemodificadatiAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $form = new Application_Form_Liv2_Modifica_FormModificadatiutente();
        $response = $form->processAjax($_POST); 
        if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    
    public function updateutenteAction () {
        if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
        }
        $this->view->modForm=$this->getModForm();
        $form=$this->_formModifica;
        
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
            return $this->render('modificadatiutente');
        }
        
        $valori=$form->getValues();
        $password=$this->view->AuthInfo('Password');
        if($valori['Password']==''){
            $valori['Password']=$password;
        }
        $this->_utenzaModel->updateUtente($valori);
        $this->_helper->redirector('areaprivata');

    }

    public function stampaordineAction() {
        $this->_helper->layout->disableLayout();
        $numordine=$this->getParam('ordine');
        if(is_null($numordine)) {$this->_helper->redirector('index');}
        else{
            $ordine= $this->_utenzaModel->estraiOrdinePerNumero($numordine);
            if ($ordine->Utente==$this->view->AuthInfo('Username')){
                $evento=$this->_catalogModel->estraiEventoPerId($ordine->Evento);
                $this->view->assign(array('ordine'=>$ordine,'evento'=>$evento));
            }
            else {$this->_helper->redirector('index');}
        }
    }

    public function checkoutAction()
    {
            $IdEv= $this->getParam('evento');
            if(is_null($IdEv)){
                $this->_helper->redirector('index');
            }
            $ev=$this->_catalogModel->estraiEventoPerId($IdEv);
            $this->view->assign(array('evento'=>$ev));
            $this->view->formAcquisto=$this->getFormAcquisto($IdEv); //serve per passare l'id dell'evento all'altro form così da poterlo usare nel campo hidden
    }

    public function completacheckoutAction(){
        if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
        if(is_null($this->getParam('evento'))){
            $this->_helper->redirector('index');
        }

            $user=$this->view->authInfo('Username');
            $IdEv=$this->getParam('evento');
            $this->view->formAcquisto=$this->getFormAcquisto($IdEv);
            $form=$this->_formAcquisto;
            $ev=$this->_catalogModel->estraiEventoPerId($IdEv);

            if (!$form->isValid($_POST)) {
                $this->view->assign(array('evento'=>$ev));
                $form->setDescription('Attenzione: controllare i dati inseriti');
                return $this->render('checkout');
            }

            $valori=$form->getValues();

            $valori['Evento']=$IdEv;

            $user=$this->view->authInfo('Username');
            $this->_catalogModel->insertOrdine($user,$valori);

            $this->_helper->redirector('storico');
        }
    public function partecipazioneAction(){

          $IdEv= $this->getParam('evento');
          $user=$this->view->authInfo('Username');
          $partecipato=(is_null($this->_catalogModel->estraiPartecipazione($IdEv,$user)))? false : true ;
          if(!$partecipato){ //questo controllo è necessario per prevenire il problema di un eventuale doppio click sul tasto partecipa che lancia 2 azioni e quindi sql da errore
            $this->_catalogModel->insertPartecipazione($user, $IdEv);
          }

          $this->_helper->redirector('catalogo','liv1',null,array('evento' => $IdEv));

    }
    private function getFormAcquisto($IdEv=null)
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formAcquisto = new Application_Form_Liv2_Acquisto_FormAcquisto(array('evento'=>$IdEv));
        $this->_formAcquisto->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'completacheckout',
                ),
                'default',false
                ));
        return $this->_formAcquisto;
    }

    private function getModForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formModifica = new Application_Form_Liv2_Modifica_FormModificadatiutente();
        $this->_formModifica->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'updateutente',),
                'default',true
                ));
        return $this->_formModifica;
    }

    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }


}
