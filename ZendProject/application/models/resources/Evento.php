<?php

class Application_Resource_Evento extends Zend_Db_Table_Abstract
{
    protected $_name    = 'evento';
    protected $_primary  = 'Id';
    protected $_rowClass = 'Application_Resource_Evento_Item';

	public function init()
    {
    }
    
    public function estraiEventoPerId($IdEv) {
         return $this->find($IdEv)->current();
    }
	// Estrae i prodotti della tipologia $tipologia, eventualmente paginati ed ordinati. Può essere usata anche per estrarre tutti gli eventi, passandogli l'insieme di tutte le tipologie nella variabile $tipologia
    public function estraiEventiPerTipo($tipologia, $paged=null, $order=null)
    {
        $select = $this->select()->where('Tipologia IN(?)', $tipologia);
        if (true === is_array($order)) {
            $select->order($order);
        }
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);   //restituisce un oggetto contenente il rowset da paginare
			$paginator = new Zend_Paginator($adapter);  //è un oggetto che wrappa i dati provenienti dal db e risultanti dalla select effettuata; rispetto al metodo fetchAll ha dei metodi fatti per specificare la paginazione
			$paginator->setItemCountPerPage(1)
		          	  ->setCurrentPageNumber((int) $paged); //va fatto il casting perchè il metodo cuole un int, invece paged è una stringa
			return $paginator;
		}
        return $this->fetchAll($select);
    } 

	// Estrae i prodotti IN SCONTO della tipologia $tipologia, eventualmente paginati ed ordinati
    public function ottieniEventiInSconto($tipologia, $paged=null, $order=null)
    {
        $select = $this->select()
        			   ->where('Tipologia IN(?)', $tipologia) 
        			   ->where('Sconto>0')                                      //query per estrarre gli eventi in sconto. Credo sia il modo migliore per estrarre direttamente gli elementi scontati dal db
                                   ->where('CURRENT_TIMESTAMP() >= Data_Inizio_Sconto');
        if (true === is_array($order)) {
            $select->order($order);
        }
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    public function estraiUltimiEvInseriti($numgiorni,$paged=null, $order=null) {   //estrae eventi inseriti meno di $numgiorni fa
        $select = $this->select()
        			   ->where('Data_Inserimento > SUBDATE(CURRENT_TIMESTAMP(), (?))', $numgiorni)->order('Data_Inserimento DESC');
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
}



