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
    protected $_formTastoacquisto;
    
    protected $_authService;

    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->_faqModel=new Application_Model_Faq;
        $this->_catalogModel=new Application_Model_Catalogo();
        $this->_utenzaModel = new Application_Model_Utenza();
        $this->view->filtroForm = $this->getFiltroForm();
        $this->view->filtroRicerca = $this->getRicercaForm();
        $this->view->formLogin = $this->getLoginForm();
        $this->view->regForm=$this->getRegForm();
        
        
	$this->_authService = new Application_Service_Autenticazione();
        
    }
    public function indexAction()
    {
        $page=$this->_getParam('page',1);
        $pagescont=$this->_getParam('pagescont',1);
        $ultimieventi=$this->_catalogModel->estraiUltimiEventi($page);
        $eventiscontati=$this->_catalogModel->ottieniEventiInSconto($pagescont);
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
        $paged = $this->_getParam('page', 1);
        $tiporic=$this->_getParam('tiporic',null);
        
        
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
                $eventi= $this->_catalogModel->filtro($paged,$this->settaNullCondizionale($valori['Username']), $this->settaNullCondizionale($valori['Mese']),$this->settaNullCondizionale($valori['Anno']),$this->settaNullCondizionale($valori['Luogo']),$this->settaNullCondizionale($valori['Tipologia']));
            } 
            
            
            else if($tiporic=='ricerca'){
                if (!$this->getRequest()->isPost()) {
                    $this->_helper->redirector('index');
                }
                $form=$this->_formRicerca;
                if (!$form->isValid($_POST)) {
			return $this->render('ricerca');}
               $valori=$form->getValues();
               $eventi= $this->_catalogModel->ricerca($paged, $this->settaNullCondizionale($valori['Mese']),$this->settaNullCondizionale($valori['Anno']),$this->settaNullCondizionale($valori['Luogo']),$this->settaNullCondizionale($valori['Tipologia']),$this->settaNullCondizionale($valori['Descrizione']) );
            }
            
            else {$this->_helper->redirector('catalogo','liv1');}
        }
        
        else if(!is_null($IdEv)){
            $eventi=$this->_catalogModel->estraiEventoPerId($IdEv);
        }
        
        else { $eventi=$this->_catalogModel->estraiEventi($paged);}
        
        
        $this->view->assign(array('eventi'=>$eventi,'EvSelezionato'=>$IdEv));
        $this->view->tastoacquistoForm=$this->getTastoacquistoForm($IdEv);
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
    private function settaNullCondizionale($elemento){
        return ($elemento != '') ? $elemento : null;
    }
    public function registrazioneAction() {
        
    }
    public function inserisciutenteAction() {
        if (!$this->getRequest()->isPost()) {
                        $this->_helper->redirector('index');
            }
        $form=$this->_formReg;
        if (!$form->isValid($_POST)) {
			$form->setDescription('Attenzione: controlla che i dati inseriti siano del formato giusto.');
                       return $this->render('registrazione');
            }
        $valori=$form->getValues();
        $this->_utenzaModel->insertUtente($valori);
        $this->_helper->redirector('index');
    }
	
    public function loginAction() 
    {
    }
    
    public function autenticazioneAction()
    {        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_formLogin;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: credenziali inserite errate.');
            return $this->render('login');
        }
        if (false === $this->_authService->autenticazione($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        return $this->_helper->redirector('index', $this->RimappaUtenti($this->_authService->getIdentity()->Ruolo));
    }
    private function RimappaUtenti($ruolo) {
        $livello=null;
        switch ($ruolo) {
            case 'utente':
                $livello='liv2';
                break;
            case 'organizzazione':
                $livello='liv3';
                break;
            case 'admin':
                $livello='liv4';
                break;
            default:
                break;
        }
        return $livello;
    }
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
    private function getTastoacquistoForm($IdEv)
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
}