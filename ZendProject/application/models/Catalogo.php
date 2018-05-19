<?php
class Application_Model_Catalogo extends App_Model_Abstract
{ 

	public function __construct()
    {
		$this->_logger = Zend_Registry::get('log');  	
	}

    public function estraiCategorie()
    {
		return $this->getResource('Tipologia')->estraiCategorie();
    }
       
    public function estraiEventiPerTipo($tipologia, $paged=null, $order=null)
    {     
        return $this->getResource('Evento')->estraiEventiPerTipo($tipologia, $paged, $order);
    }    
    
    public function ottieniEventiInSconto($tipologia, $paged=null, $order=null)
    {     
        return $this->getResource('Evento')->ottieniEventiInSconto($tipologia, $paged, $order);
    }
    public function estraiUltimiEvInseriti($numgiorni, $paged=null, $order=null)
    {     
        return $this->getResource('Evento')->estraiUltimiEvInseriti($numgiorni, $paged, $order);
    }
}

