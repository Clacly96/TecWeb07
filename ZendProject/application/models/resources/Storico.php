<?php

class Application_Resource_Storico extends Zend_Db_Table_Abstract
{
    protected $_name    = 'storico';
    protected $_primary  = 'Numero_Ordine';
    protected $_rowClass = 'Application_Resource_Storico_Item';
    protected $_logger;

    public function init()
    {
        //    $this->_logger = Zend_Registry::get('log');
    }
    
    public function estraiOrdinePerNumero($NumOrdine) {
         return $this->find($NumOrdine)->current();
    }
    public function estraiOrdiniPerUtente($paged=null,$utente) {
        $select = $this->select()->where('Utente =(?)',$utente)->order('Data_Ora DESC');
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(3)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
    public function insertOrdine($utente,$ordine,$totale)
    {
        
        $dati = array( 'Utente' => $utente,
		    'Evento' => $ordine['Evento'],
		    'Modalita_Pagamento' => $ordine['Modalita_Pagamento'],
		    'Numero_Biglietti' => $ordine['Numero_Biglietti'],
		    'Totale'=>$totale
                     );
        $insert=$this->insert($dati);
    }
    
    public function estraiBiglVendPerEv($idEv){
        $select=$this->select()->from('storico', array('Evento','sum(Numero_Biglietti) as Biglietti_Venduti'))
                ->where('Evento IN (?)',$idEv)->group('Evento');
        $biglietti= $this->fetchAll($select);
        $bigliassoc=array();
        foreach($biglietti as $biglietto){
            $bigliassoc[$biglietto['Evento']]=$biglietto['Biglietti_Venduti'];
        }
        foreach($idEv as $evento){ //importante per creare il vettore associativo con tutti gli eventi presenti della variabile IdEv che non compaiono come risultato della query perchè non presenti nella tabella
            if(!isset($bigliassoc[$evento]))
                $bigliassoc[$evento]=0;
        }
        
        return $bigliassoc;
    }
    
    public function estraiIncassoPerEv($idEv){
        $select=$this->select()->from('storico', array('Evento','sum(Totale) as Incasso'))
                ->where('Evento IN (?)',$idEv)->group('Evento');
        $incassi= $this->fetchAll($select);
        $incassiassoc=array();
        foreach($incassi as $incasso){
            $incassiassoc[$incasso['Evento']]=$incasso['Incasso'];
        }
        foreach($idEv as $evento){ //importante per creare il vettore associativo con tutti gli eventi presenti della variabile IdEv che non compaiono come risultato della query perchè non presenti nella tabella
            if(!isset($incassiassoc[$evento]))
                $incassiassoc[$evento]=0;
        }
        return $incassiassoc;
    }
    
    public function estraiIncassoPeriodo($date,$eventi=null){
    $select= $this->select()->from('storico', array('sum(Totale) as Incasso'))
            ->where("CAST(Data_Ora AS DATE) BETWEEN CAST( '".$date['Data_Inizio']."' AS DATE) AND CAST( '".$date['Data_Fine']."' AS DATE)")
            ->where('Evento IN (?)',$eventi); // per prendere solo gli eventi dell'organizzazione
     $incasso=$this->fetchRow($select);
     return $incasso['Incasso'];
    
    
    }
}




