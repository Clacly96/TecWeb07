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
        $select = $this->select()->where('Utente =(?)',$utente);
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(1)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
    public function insertOrdine($utente,$ordine)
    {
        
        $dati = array( 'Utente' => $utente,
		    'Evento' => $info['Evento'],
		    'Modalita_Pagamento' => $ordine['Modalita_Pagamento'],
		    'Numero_Biglietti' => $ordine['Numero_Biglietti']
		    
                     );
        $insert=$this->insert($dati);
    }
}




