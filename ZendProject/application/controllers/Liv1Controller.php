<?php

class Liv1Controller extends Zend_Controller_Action
{
    protected $_catalogModel;
    public function init()
    {
        $this->_helper->layout->setLayout('main');
        $this->_catalogModel=new Application_Model_Catalogo();
        
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
    }
    public function ricercaAction()
    {
    }
    public function listaorganizzazioniAction()
    {
    }
    public function faqAction(){
        
    }
}

