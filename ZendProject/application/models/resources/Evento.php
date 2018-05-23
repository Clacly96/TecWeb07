<?php

class Application_Resource_Evento extends Zend_Db_Table_Abstract
{
    protected $_name    = 'Evento';
    protected $_primary  = 'Id';
    protected $_rowClass = 'Application_Resource_Evento_Item';

	public function init()
    {
    }
    
    public function estraiEventoPerId($IdEv) {
         return $this->find($IdEv)->current();
    }
    
    public function estraiEventi($paged=null)
    {
        $select=$this->select()->where('CURRENT_TIMESTAMP() <= Data_Fine_Acquisto')->order('Nome ASC');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);   //restituisce un oggetto contenente il rowset da paginare
			$paginator = new Zend_Paginator($adapter);  //è un oggetto che wrappa i dati provenienti dal db e risultanti dalla select effettuata; rispetto al metodo fetchAll ha dei metodi fatti per specificare la paginazione
			$paginator->setItemCountPerPage(6)
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
			$paginator->setItemCountPerPage(3)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }

    
    public function estraiUltimiEventi($paged=null)
    {
        $select=$this->select()->where('Data_Inserimento >= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 7 DAY) && CURRENT_TIMESTAMP() <= Data_Fine_Acquisto')
                                ->order('Nome ASC');
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(6)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    // funzione utile di mysql per la ricerca SELECT * FROM Table_name Where Month(date)='10' && YEAR(date)='2016';

    
    public function filtro($paged=null,$org=null,$data=null,$luogo=null,$cat=null) {        
        $select=$this->select()->where('CURRENT_TIMESTAMP() <= Data_Fine_Acquisto'); // prendiamo solo gli eventi ancora attivi
        if (!is_null($org)){
            $select->where('Organizzazione =(?)',$org);
        }
        if (!is_null($data)){
            $select->where("DATE_FORMAT(Data_Ora,'%Y%m%d')=(?)",$data);
        }
        if (!is_null($luogo)){
            $select->where("Luogo=(?)",$luogo);
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
            
}



