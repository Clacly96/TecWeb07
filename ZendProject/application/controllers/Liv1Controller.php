<?php
class Liv1Controller extends Zend_Controller_Action
{
    protected $_faqModel;
    protected $_catalogModel;
    protected $_utenzaModel;
    protected $_formFiltro;
    protected $_formRicerca;
    protected $_formLogin;
    protected $_formReg;

    protected $_authService;
    
    protected $_flashMessenger = null;
    
    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->_faqModel=new Application_Model_Faq;
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->view->filtroRicerca = $this->getRicercaForm();
        
        $this->_flashMessenger =$this->_helper->getHelper('FlashMessenger');

	$this->_authService = new Application_Service_Autenticazione();

    }
    public function indexAction()
    {
        $page=$this->_getParam('page',1);
        $pagescont=$this->_getParam('pagescont',1);
        $ultimieventi=$this->_catalogModel->estraiUltimiEventi($page);
        $eventiscontati=$this->_catalogModel->ottieniEventiInSconto($pagescont);
        if(!is_null($this->_flashMessenger->getMessages())){
            $this->view->messages = $this->_flashMessenger->getMessages();
            //$this->render();
        }
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
        $SelCat=$this->_getParam('SelCat',null);
        $cat=$this->_catalogModel->estraiCategorie();
        $paged = $this->_getParam('page', 1);
        $tiporic=$this->_getParam('tiporic',null);
        $partecipato=null;
        $numpart=null;

        if(!is_null($tiporic)){
            if($tiporic=='filtro'){                
                if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
                }
                $form=$this->_formFiltro;
                if (!$form->isValid($_POST)) {
                       return $this->render('catalogo');
                }
                $valori=$form->getValues();
                $eventi= $this->_catalogModel->filtro($paged,
                        $this->settaNullCondizionale($valori['Username']), 
                        $this->settaNullCondizionale($valori['Mese']),
                        $this->settaNullCondizionale($valori['Anno']),
                        $this->settaNullCondizionale($valori['Luogo']),
                        $this->settaNullCondizionale($valori['Tipologia']));
            }

            else if($tiporic=='ricerca'){
                if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
                $form=$this->_formRicerca;
                if (!$form->isValid($_POST)) {
			return $this->render('ricerca');}
                $valori=$form->getValues();
                $eventi= $this->_catalogModel->ricerca($paged, 
                       $this->settaNullCondizionale($valori['Mese']),
                       $this->settaNullCondizionale($valori['Anno']),
                       $this->settaNullCondizionale($valori['Luogo']),
                       $this->settaNullCondizionale($valori['Tipologia']),
                       $this->settaNullCondizionale($valori['Descrizione']) );
            }
            else {$this->_helper->redirector('catalogo','liv1');}
        }
        else if(!is_null($IdEv)){  //estrae singolo evento
            $utente=$this->view->authInfo('Username');
            $eventi=$this->_catalogModel->estraiEventoPerId($IdEv);
            if(!is_null($utente)){
                $partecipato=(is_null($this->_catalogModel->estraiPartecipazione($IdEv,$utente)))? false : true ;
            }
            $numpart=$this->_catalogModel->contaPartecipazioniPerEv($IdEv);
        }
        else if(!is_null($SelCat)){
            $eventi=$this->_catalogModel->filtro($paged,null,null,null,null,$SelCat);
            
            
               
        } else{ $eventi=$this->_catalogModel->estraiEventi($paged);}//estrae lista eventi

        $this->view->assign(array('cat'=>$cat,'eventi'=>$eventi,'EvSelezionato'=>$IdEv,'partecipato'=>$partecipato,'numpart'=>$numpart));

    }
    
    public function filtroajaxAction(){
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if (!$this->getRequest()->isPost()) {
                $this->_helper->redirector('index');
        }
        $form=$this->_formFiltro;
        if (!$form->isValid($_POST)) {
               return $this->render('catalogo');
        }
        $valori=$form->getValues();
        $eventi= $this->_catalogModel->filtro(null,
                $this->settaNullCondizionale($valori['Username']), 
                $this->settaNullCondizionale($valori['Mese']),
                $this->settaNullCondizionale($valori['Anno']),
                $this->settaNullCondizionale($valori['Luogo']),
                $this->settaNullCondizionale($valori['Tipologia']));

        $vettoreEventi=array();
        foreach ($eventi as $evento) {
            $vettoreEventi[]=$this->view->AnteprimaEvento($evento,'anteprima');
        }
        $this->_helper->json($vettoreEventi);
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
    
    public function registrazioneAction() {
        $this->view->regForm=$this->getRegForm();
    }
    public function validazioneregistrazioneAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $form = new Application_Form_Liv1_Utenza_Registrazione();
        $response = $form->processAjax($_POST); 
        if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
    public function inserisciutenteAction() {
        if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
            }
        $this->view->regForm=$this->getRegForm();
        $form=$this->_formReg;
        if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
                       return $this->render('registrazione');
            }
        $valori=$form->getValues();
        $this->_utenzaModel->insertUtente($valori);
        $this->_flashMessenger->addMessage('Registrazione avvenuta con successo. Ora puoi accedere al sito!');
        $this->_helper->redirector('index');
    }

    public function loginAction()
    {
        $this->view->formLogin = $this->getLoginForm();
    }

    public function autenticazioneAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $this->view->formLogin = $this->getLoginForm();
        $form = $this->_formLogin;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: credenziali inserite errate.');
            return $this->render('login');
        }
        if (false === $this->_authService->autenticazione($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        $this->_flashMessenger->addMessage('Login avvenuto con successo!');
        $this->_helper->redirector('index', 'liv1');
    }
    /***********************Fine Action******************************************/
    
    
    /**************************Funzioni private*************************************************/
    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }
    
    
    /************Inizio get form*********************/
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
    private function getRegForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formReg = new Application_Form_Liv1_Utenza_Registrazione();
        $this->_formReg->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'inserisciutente'),
                'default',true
                ));
        return $this->_formReg;
    }
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formLogin = new Application_Form_Liv1_Utenza_Login();
        $this->_formLogin->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'autenticazione',),
                'default',true
                ));
        return $this->_formLogin;
    }
}
