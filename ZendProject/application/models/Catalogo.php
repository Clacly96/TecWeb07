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
    
    public function ottieniEventiInSconto($paged=null)
    {     
        return $this->getResource('Evento')->ottieniEventiInSconto($paged);
    }
     public function estraiUltimiEventi($paged=null)
    {     
        return $this->getResource('Evento')->estraiUltimiEventi($paged);
    }
    
    public function estraiEventoPerId($IdEv){
        return $this->getResource('Evento')->estraiEventiPerId($IdEv);
    }
}

