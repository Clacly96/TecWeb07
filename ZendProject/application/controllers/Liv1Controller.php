<?php

class Liv1Controller extends Zend_Controller_Action
{
    protected $_formLogin;
    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->view->formLogin = $this->getLoginForm();
    }
    public function indexAction()
    {
    }
    public function vistastaticaAction()
    {
        $page = $this->_getParam('pagina');
        $this->render($page);
    }
    public function catalogoAction()
    {
    }
    public function ricercaAction()
    {
    }
    public function listaorganizzazioniAction()
    {
    }
    public function faqAction(){

    }
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formLogin = new Application_Form_Liv1_Utenza_Login();
        $this->_formLogin->setAction($urlHelper->url(array(
                'controller' => 'liv1',
                'action' => 'index',),
                'default'
                ));
        return $this->_formLogin;
    }
}
