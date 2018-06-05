<?php

class Application_Resource_Partecipazione extends Zend_Db_Table_Abstract
{
    protected $_name    = 'partecipazione';
    protected $_primary  = array('Utente','Evento');
    protected $_rowClass = 'Application_Resource_Partecipazione_Item';
    protected $_logger;

    public function init()
    {
        //    $this->_logger = Zend_Registry::get('log');
    }

    public function estraiPartecipazione($idEv=null,$utente=null){
        $select=$this->select()->where('Evento =(?)',$idEv);
        if(!is_null($utente)){
            $select->where('Utente =(?)',$utente);
        }
        return $this->fetchRow($select);
    }

    public function estraiPartecipazioni(){
        $select=$this->select();
        return $this->fetchAll($select);
    }

    public function estraiPartecipazioniPerEv($IdEv){
        $select=$this->select()->where('Evento=(?)',$IdEv);
        return $this->fetchAll($select);
    }

      public function insertPartecipazione($utente,$evento)
    {

        $dati = array( 'Utente' => $utente,
		    'Evento' => $evento
		     );
        $insert=$this->insert($dati);
    }

    public function contaPartecipazioniPerEv($IdEv,$more=null) //more serve per mantere la funzione utilizzabile nel codice già scritto, senza ritoccare nulla
    {
        if(is_null($more)){
        $select=$this->select()->where('Evento=(?)',$IdEv);
        return count($this->fetchAll($select)->toArray());
        } 
        $select=$this->select()->from('partecipazione',array('Evento','COUNT(*) AS Num_Partecipazioni'))
                ->where('Evento IN (?)',$IdEv)->group('Evento');
        $partecipazioni= $this->fetchAll($select);
        $partassoc=array();
        foreach ($partecipazioni as $partecipazione){
            $partassoc[$partecipazione['Evento']]=$partecipazione['Num_Partecipazioni'];
        }
        foreach($IdEv as $evento){ //importante per creare il vettore associativo con tutti gli eventi presenti della variabile IdEv che non compaiono come risultato della query perchè non presenti nella tabella
            if(!isset($partassoc[$evento]))
                $partassoc[$evento]=0;
        }
        return $partassoc;
    }
    
    


}
