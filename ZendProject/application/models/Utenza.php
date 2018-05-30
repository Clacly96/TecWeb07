<?php
class Application_Model_Utenza extends App_Model_Abstract
{ 
	public function __construct()
    {
	//$this->_logger = Zend_Registry::get('log');  	
    }
   
    public function getOrg($paged=null)
    {     
        return $this->getResource('Utente')->getOrg($paged);
    }    
    
    public function getUtenteByUsername($username)
    {
        return $this->getResource('Utente')->getUtenteByUsername($username);
    }
    
    public function getUtenti() {
        return $this->getResource('Utente')->getUtenti();        
    }
    
    public function getEmails() {
        return $this->getResource('Utente')->getEmails();
    }
    public function getTelefoni() {
        return $this->getResource('Utente')->getTelefoni();
    }
    
    public function insertUtente($info) {
        return $this->getResource('Utente')->insertUtente($info);
    }
    public function estraiOrdinePerNumero($NumOrdine) {
        return $this->getResource('Storico')->estraiOrdinePerNumero($NumOrdine);
    }
    public function estraiOrdiniPerUtente($paged=null,$utente) {

        $ordini= $this->getResource('Storico')->estraiOrdiniPerUtente($paged,$utente);
        $ordininonpg=array();
        foreach ($ordini as $ordine) {
            $ordininonpg[$ordine['Numero_Ordine']]=$ordine['Evento'];
        }
        $nomi = $this->getResource('Evento')->estraiNomeEventi($ordininonpg);
        $ordiniEnomiEventi['ordini']=$ordini;
        $ordiniEnomiEventi['nomieventi']=$nomi;
        return $ordiniEnomiEventi;

    }
	
    public function updateUtente($info) {
        return $this->getResource('Utente')->updateUtente($info);
    }
}


