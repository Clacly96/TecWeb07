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
        $luoghi= $this->getResource('Evento')->estraiLuoghi();
        $citta=array();
        foreach ($luoghi as $luogo) {
            $luog= explode('-', $luogo->Luogo);
            $citta[]=$luog[0];
        }
        return $citta;
    }
    public function ricerca($paged=null,$mese=null,$anno=null,$luogo=null,$cat=null,$desc=null){
        return $this->getResource('Evento')->ricerca($paged,$mese,$anno,$luogo,$cat,$desc);
    }
    public function insertOrdine($utente,$ordine) //non so se sono necessari controlli
    {
        $Ev=$this->getResource('Evento')->estraiEventoPerId($ordine['Evento']);
        $prezzoEv=$Ev->ottieniPrezzo();
        $totale=$prezzoEv*$ordine['Numero_Biglietti'];
        $this->getResource('Storico')->insertOrdine($utente,$ordine,$totale);
    }
    
    public function estraiPartecipazioniPerEv($IdEv)
    {
       return $this->getResource('Partecipazione')->estraiPartecipazioniPerEv($IdEv);
    }
      public function estraiPartecipazioni()
    {
        return $this->getResource('Partecipazione')->estraiPartecipazioni();
    }
    public function estraiPartecipazione($idEv,$utente)
    {
        return $this->getResource('Partecipazione')->estraiPartecipazione($idEv,$utente);
    }
    
     public function insertPartecipazione($utente,$evento)
     {
         $this->getResource('Partecipazione')->insertPartecipazione($utente,$evento);
     }
     
     public function contaPartecipazioniPerEv($IdEv){
        return $this->getResource('Partecipazione')->contaPartecipazioniPerEv($IdEv);
     }
     public function inserisciEvento($ev) {
         $this->getResource('Evento')->inserisciEvento($ev);
     }
     public function modificaEvento($ev) {
         $this->getResource('Evento')->modificaEvento($ev);
     }
     public function estraiEventiPerOrganizzazione($paged=null,$organizzazione) {
         return $this->getResource('Evento')->estraiEventiPerOrganizzazione($paged,$organizzazione);
     }
     public function cancellaEvento($IdEv) {
         $this->getResource('Evento')->cancellaEvento($IdEv);
     }

     
     public function estraiStatistichePerOrg($organizzazione,$paged=null) {
         $eventi=$this->getResource('Evento')->estraiEventiPerOrganizzazione($paged,$organizzazione);
         $eventinonpg=array();
         foreach ($eventi as $evento) {
            $eventinonpg[]=$evento['Id'];
        }
         $nomiEv = $this->getResource('Evento')->estraiNomeEventi($eventinonpg);
         $biglrimanenti= $this->getResource('Evento')->estraiBigliettiRimanenti($eventinonpg);
         $biglvenduti=$this->getResource('Storico')->estraiBiglVendPerEv($eventinonpg);
         $incassi=$this->getResource('Storico')->estraiIncassoPerEv($eventinonpg);
         $partecipazioni=$this->getResource('Partecipazione')->contaPartecipazioniPerEv($eventinonpg,true);
         $bigltotali=array();
         $biglperc=array();
         foreach($eventinonpg as $evento){
                $bigltotali[$evento]=$biglvenduti[$evento]+$biglrimanenti[$evento];  // da ottimizzare il calcolo di biglperc in un unico ciclo
                $biglperc[$evento]=($biglvenduti[$evento]/$bigltotali[$evento])*100;
                
         }
         
         $tuplastatistica=array();
         foreach($eventinonpg as $evento){
             $tuplastatistica[$evento]['nome']=$nomiEv[$evento];
             $tuplastatistica[$evento]['biglettiVenduti']=$biglvenduti[$evento];
             $tuplastatistica[$evento]['percBiglietti']=$biglperc[$evento];
             $tuplastatistica[$evento]['incasso']=$incassi[$evento];
             $tuplastatistica[$evento]['partecipazioni']=$partecipazioni[$evento];
         }
         
         $statistica=array();
         $statistica['eventi']=$eventi;
         $statistica['tuple']=$tuplastatistica;
         
         return $statistica;
            }
            
        public function estraiIncassoPeriodo($date,$organizzazione){
            $eventi=$this->getResource('Evento')->estraiEventiPerOrganizzazione(null,$organizzazione);
            $ideventi=array();
            foreach ($eventi as $evento) {
                $ideventi[]=$evento['Id'];
            }
           return $this->getResource('Storico')->estraiIncassoPeriodo($date,$ideventi);
        }

     public function estraiUltimoId() {
         return $this->getResource('Evento')->estraiUltimoId();
     }
     
     public function insertTipologia($nome){
         return $this->getResource('Tipologia')->insertTipologia($nome);
     }
     
     public function cancellazioneTipologia($nome){
         return $this->getResource('Tipologia')->cancellazioneTipologia($nome);
     }
     public function modificaTipologia($vecchio,$nuovo){
         return $this->getResource('Tipologia')->modificaTipologia($vecchio,$nuovo);
     }

}

