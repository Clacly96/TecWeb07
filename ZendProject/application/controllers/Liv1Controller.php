<?php

class Liv1Controller extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout->setLayout('main');
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
        $page=$this->_getParam('page',1);
        $listafaq= $this->_faqModel->estraiFaq($page);
        $this->view->assign(array('listafaq'=>$listafaq));
    }
}

