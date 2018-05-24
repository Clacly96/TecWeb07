<?php
class Application_Model_Catalogo extends App_Model_Abstract
{ 

	public function __construct()
    {
	//	$this->_logger = Zend_Registry::get('log');  	
	}

    public function estraiCategorie()
    {
        return $this->getResource('Tipologia')->estraiCategorie();
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
        return $this->getResource('Evento')->estraiEventoPerId($IdEv);
    }
    public function estraiEventi($paged=null){
        return $this->getResource('Evento')->estraiEventi($paged);
    }
    public function filtro($paged=null,$org=null,$mese=null,$anno=null,$luogo=null,$cat=null){
        return $this->getResource('Evento')->filtro($paged,$org,$mese,$anno,$luogo,$cat);
    }
    public function estraiLuoghi() {
        return $this->getResource('Evento')->estraiLuoghi();
    }
    public function ricerca($paged=null,$mese=null,$anno=null,$luogo=null,$cat=null,$desc=null){
        return $this->getResource('Evento')->ricerca($paged,$mese,$anno,$luogo,$cat,$desc);
    }
}

