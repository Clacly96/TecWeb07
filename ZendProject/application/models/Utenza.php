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

    public function estraiProfiloAcquisto($paged=null,$utente){
        $profilo= $this->getResource('Storico')->estraiProfiloAcquisto($paged,$utente);
        $ordininonpg=array();
        foreach ($profilo as $ordine) {
            $ordininonpg[$ordine['Evento']]=$ordine['Evento'];
        }
        $nomi = $this->getResource('Evento')->estraiNomeEventi($ordininonpg);
        $ordiniEnomiEventi['profilo']=$profilo;
        $ordiniEnomiEventi['nomieventi']=$nomi;
        return $ordiniEnomiEventi;
    }
	
    public function updateUtente($info,$username) {
        return $this->getResource('Utente')->updateUtente($info,$username);
    }
	
    public function estraiNomeCognPerUsername($username,$paged=null) {
        return $this->getResource('Utente')->estraiNomeCognPerUsername($username,$paged);
    }
    
    public function estraiPartecipanti($IdEv,$paged=null){
        $partecipazioni=$this->getResource('Partecipazione')->estraiPartecipazioniPerEv($IdEv);
        $utenti=array();
        foreach ($partecipazioni as $part){
            $utenti[]=$part['Utente']; 
            
        }
        if(count($partecipazioni)>0)
        {
            return $this->getResource('Utente')->estraiNomeCognPerUsername($utenti,$paged);
            
        }
        
        else { return null; }
    }
	
    public function getListaUtenti($paged=null) {
        return $this->getResource('Utente')->getListaUtenti();
    }
	 
    public function getListaOrganizzazioni($paged=null) {
        return $this->getResource('Utente')->getListaOrganizzazioni();
    }
	
    public function insertOrganizzazione($info) {
        return $this->getResource('Utente')->insertOrganizzazione($info);
    }
	
    public function cancellaUtente($id) {
        return $this->getResource('Utente')->cancellaUtente($id);
    }
    
    public function cancellaOrganizzazione ($id) {
        return $this->getResource('Utente')->cancellaOrganizzazione($id);
    }
	
    public function updateOrganizzazione($info,$username) {
        return $this->getResource('Utente')->updateOrganizzazione($info,$username);
    }
}


