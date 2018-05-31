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
}




