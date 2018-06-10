<?php

class Application_Resource_Evento extends Zend_Db_Table_Abstract
{
    protected $_name    = 'Evento';
    protected $_primary  = 'Id';
    protected $_rowClass = 'Application_Resource_Evento_Item';
    protected $_logger;

    public function init()
    {
        //    $this->_logger = Zend_Registry::get('log');
    }
    
    public function estraiEventoPerId($IdEv) {
         return $this->find($IdEv)->current();
    }
    public function estraiEventiPerOrganizzazione($paged=null,$organizzazione) {
        $select=$this->select()->where('Organizzazione =(?)',$organizzazione)->order('Nome ASC');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(10)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }

    
    public function estraiEventi($paged=null)
    {
        $select=$this->select()->where('CURRENT_TIMESTAMP() <= Data_Fine_Acquisto')->order('Nome ASC');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);   //restituisce un oggetto contenente il rowset da paginare
			$paginator = new Zend_Paginator($adapter);  //è un oggetto che wrappa i dati provenienti dal db e risultanti dalla select effettuata; rispetto al metodo fetchAll ha dei metodi fatti per specificare la paginazione
			$paginator->setItemCountPerPage(5)
		          	  ->setCurrentPageNumber((int) $paged); //va fatto il casting perchè il metodo cuole un int, invece paged è una stringa
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    
   

    // Estrae i prodotti IN SCONTO della tipologia $tipologia, eventualmente paginati ed ordinati
    public function ottieniEventiInSconto($paged=null)
    {
        $select = $this->select()
        			   ->where('Sconto>0 && CURRENT_TIMESTAMP() >= Data_Inizio_Sconto && CURRENT_TIMESTAMP() <= Data_Fine_Acquisto')                                      //query per estrarre gli eventi in sconto. Credo sia il modo migliore per estrarre direttamente gli elementi scontati dal db
                                   ->order('Sconto DESC');
      
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(5)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }

    
    public function estraiUltimiEventi($paged=null)
    {
        $select=$this->select()->where('Data_Inserimento >= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 7 DAY) && CURRENT_TIMESTAMP()<=Data_Fine_Acquisto')
                                ->order('Nome ASC');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(5)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    

    
    public function filtro($paged=null,$org=null,$mese=null,$anno=null,$luogo=null,$cat=null) {        
        $select=$this->select()->where('CURRENT_TIMESTAMP() <= Data_Fine_Acquisto'); // prendiamo solo gli eventi ancora attivi
        if (!is_null($org)){
            $select->where('Organizzazione =(?)',$org);
        }
        if (!is_null($mese)){
            $select->where("MONTH(Data_Ora)=(?)",$mese);
        }
        if (!is_null($anno)){
            $select->where("YEAR(Data_Ora)=(?)",$anno);
        }
        if (!is_null($luogo)){
            $select->where("LOWER(Luogo) LIKE LOWER('%".$luogo."%')"); //usiamo il like perché sul db vengono salvati anche via e numero civico oltre alla città
        }
        if (!is_null($cat)){
            $select->where("Tipologia=(?)",$cat);
        }
        $select->order('Nome');
        if (null !=$paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(6)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    
    public function estraiLuoghi() {
        $select=$this->select()->distinct()->from('Evento',array('Luogo'))->order('Luogo ASC');
        return $this->fetchAll($select);
    }
    
    public function ricerca($paged=null,$mese=null,$anno=null,$luogo=null,$cat=null,$desc=null){
         $select=$this->select()->where('CURRENT_TIMESTAMP() <= Data_Fine_Acquisto');
       
        if (!is_null($mese)){
            $select->where("MONTH(Data_Ora)=(?)",$mese);
        }
        if (!is_null($anno)){
            $select->where("YEAR(Data_Ora)=(?)",$anno);
        }
        if (!is_null($luogo)){
            $select->where("LOWER(Luogo) LIKE LOWER('%".$luogo."%')");  //usiamo il like perché sul db vengono salvati anche via e numero civico oltre alla città
        }
        if (!is_null($cat)){
            $select->where("Tipologia=(?)",$cat);
        }
        if(!is_null($desc)){
            $select->where("LOWER(Descrizione) LIKE LOWER('%".$desc."%')"); 
        }
        
        $select->order('Nome');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(6)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
        
        
    }

    public function estraiNomeEventi($eventi){
        $select=$this->select()->from('Evento',array( 'Id', 'Nome')) 
                                ->where('Id ',$eventi);
        $result=$this->fetchAll($select);
        $nomi=array();
        foreach ($result as $risultato) {
            $nomi[$risultato['Id']]=$risultato['Nome'];
        }
        return $nomi;
    }

    public function inserisciEvento($ev) {
        $evento=array();
        $evento['Id']=$ev['IdEv'];
        $evento['Nome']=$ev['Nome'];
        $evento['Descrizione']=$ev['Descrizione'];
        $evento['Luogo']= implode('-', array($ev['Citta'],$ev['Via'],$ev['Civico']));
        $dataora=$ev['Data'].' '.implode(':',array($ev['Ora'],$ev['Minuti'],'00'));
        $evento['Data_Ora']=$dataora;
        $evento['Programma']=$ev['Programma'];
        $evento['Biglietti_Rimanenti']=$ev['Biglietti_Rimanenti'];
        $evento['Tipologia']=$ev['Tipologia'];
        $evento['Organizzazione']=$ev['Organizzazione'];
        $evento['Sconto']=$ev['Sconto'];
        
        $data= new Zend_Date($ev['Data']);
        $data->subDay($ev['Giorni_Sconto']);
        
        $evento['Data_Inizio_Sconto']=$data->toString('yyyy-MM-dd');
        $evento['Data_Fine_Acquisto']=$ev['Data_Fine_Acquisto'];
        $evento['Prezzo_Biglietto']=$ev['Prezzo_Biglietto'];
        $evento['Locandina']=$ev['Locandina'];
        $evento['Mappa']=$ev['Mappa'];
        $this->insert($evento);
    }
    public function modificaEvento($ev) {
        $evento=array();
        $evento['Nome']=$ev['Nome'];
        $evento['Descrizione']=$ev['Descrizione'];
        $evento['Luogo']= implode('-', array($ev['Citta'],$ev['Via'],$ev['Civico']));
        $dataora=$ev['Data'].' '.implode(':',array($ev['Ora'],$ev['Minuti'],'00'));
        $evento['Data_Ora']=$dataora;
        $evento['Programma']=$ev['Programma'];
        $evento['Biglietti_Rimanenti']=$ev['Biglietti_Rimanenti'];
        $evento['Tipologia']=$ev['Tipologia'];
        $evento['Organizzazione']=$ev['Organizzazione'];
        $evento['Sconto']=$ev['Sconto'];
        
        $data= new Zend_Date($ev['Data']);
        $data->subDay($ev['Giorni_Sconto']);
        
        $evento['Data_Inizio_Sconto']=$data->toString('yyyy-MM-dd');
        $evento['Data_Fine_Acquisto']=$ev['Data_Fine_Acquisto'];
        $evento['Prezzo_Biglietto']=$ev['Prezzo_Biglietto'];
        $evento['Locandina']=$ev['Locandina'];
        $evento['Mappa']=$ev['Mappa'];
        
        $where['Id = (?)'] = $ev['Id'];
        $this->update($evento, $where);
    }
    public function cancellaEvento($IdEv) {
        $this->delete(array("Id=(?)"=>$IdEv));
    }

    
    public function estraiBigliettiRimanenti($idEv){
        $select=$this->select() // ->from(array('evento'),array('Id','Biglietti_Rimanenti')) da errore di joi perchè sopra la tabella è scritta con la E maiuscola
                ->where('Id IN (?)',$idEv);
        $biglietti= $this->fetchAll($select);
        $bigliassoc=array();
        foreach($biglietti as $biglietto){
            $bigliassoc[$biglietto['Id']]=$biglietto['Biglietti_Rimanenti'];
        }
        return $bigliassoc;
    }
    
    

    public function estraiUltimoId() {
        $select = $this->select()->from('Evento',array('Id'))->order('Id DESC')->limit(1);
        return $this->fetchRow($select);
    }
    
    public function setDefaultTipologia($tipologia){
         
        $valore=array(
            'Tipologia' => null
        );
         $where=array(
            'Tipologia=(?)'=>$tipologia
        );
         $this->update($valore, $where);
    }

            
}



