<?php

class Liv2Controller extends Zend_Controller_Action
{
    protected $_utenzaModel;
    protected $_catalogModel;
    protected $_authService;
    protected $_formAcquisto;
    protected $_formTastopartecipazione;

    public function init(){
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->_authService = new Application_Service_Autenticazione();
        $this->view->tastopartecipazioneForm=$this->getTastopartecipazioneForm($IdEv=null);

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
          
          $this->_catalogModel->insertPartecipazione($user, $IdEv);
          $this->_helper->redirector('index');

    }

    private function getTastopartecipazioneForm($IdEv)
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formTastopartecipazione = new Application_Form_Liv2_Partecipazione_Tastopartecipazione();
        $this->_formTastopartecipazione->setAction($urlHelper->url(array(
                'controller' => 'liv2',
                'action' => 'partecipazione'),
                'default',true
                ));
         $this->_formTastopartecipazione->addElement('hidden', 'Evento', array(
                        'required' => false,
                        'value' => $IdEv,
                ));

        return $this->_formTastopartecipazione;
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



    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }


}
