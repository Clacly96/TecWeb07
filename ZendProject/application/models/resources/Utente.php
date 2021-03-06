<?php
class Application_Resource_Utente extends Zend_Db_Table_Abstract {
    protected $_name = 'utente';
    protected $_primary = 'Username';
    protected $_rowClass = 'Application_Resource_Utente_Item';
    
    public function init() 
    {
    }
    

    public function getUtenteByUsername($username) 
    {
        return $this->find($username)->current();

    }
    
    public function getOrg($paged=null)
    {
        $select = $this->select()

                ->where("Ruolo = 'liv3'")
                ->order('Username');

        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(10)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
    
    //prende tutti gli utenti(utenti, organizz, admin)
    public function getUtenti()
    {
        $select=$this->select()
                ->from('utente', array('Username'));
        return $this->fetchAll($select);
    }
    
    public function getEmails()
    {
        $select=$this->select()
                ->from('utente', array('Email'));
        return $this->fetchAll($select);
    }
    
    public function getTelefoni()
    {
        $select=$this->select()
                ->from('utente', array('Telefono'));
        return $this->fetchAll($select);
    }
    
    public function insertUtente($info)
    {
        
        $residenza=$info['Citta'].'-'.$info['Via'].'-'.$info['Civico'];
        $dati = array( 'Username' => $info['Username'],
		    'Password' => $info['Password'],
		    'Nome' => $info['Nome'],
		    'Cognome' => $info['Cognome'], // da ottimizzare
		    'Email' => $info['Email'],
                    'Residenza' => $residenza,
		    'Ruolo' => 'liv2',
                    'Telefono' => $info['Telefono']
                     );
        $insert=$this->insert($dati);
    }
	
    public function updateUtente ($info,$username) {
        
        $residenza=$info['Citta'].'-'.$info['Via'].'-'.$info['Civico'];
        $where['Username = ?'] = $username;
        $dati = array( 'Username' => $info['Username'],
		    'Password' => $info['Password'],
		    'Nome' => $info['Nome'],
		    'Cognome' => $info['Cognome'],
		    'Email' => $info['Email'],
                    'Residenza' => $residenza,
		    'Ruolo' => 'liv2',
                    'Telefono' => $info['Telefono']
                     );
        $update=$this->update($dati, $where);
    }
	
    public function updateOrganizzazione($info,$username) {
        
        $sede=$info['Citta'].'-'.$info['Via'].'-'.$info['Civico'];
        $where['Username = ?'] = $username;
        $dati = array( 'Username' => $info['Username'],
		    'Password' => $info['Password'],
		    'Email' => $info['Email'],
                    'Ruolo' => 'liv3',
                    'Descrizione' => $info['Descrizione'],
                    'Missione' => $info['Missione'],
                    'Telefono' => $info['Telefono'],
                    'Fax' => $info['Fax'],
                    'Sede' => $sede,
                    'Logo' => $info['Logo']
        );
        $update=$this->update($dati, $where);
    }
    
    public function estraiNomeCognPerUsername($username,$paged=null) {
        $select= $this->select()
                ->where('Username IN (?)',$username)->order('Cognome DESC');
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(10)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
	
    public function getListaUtenti($paged=null)
    {
        $select=$this->select()
                ->where("Ruolo='liv2'")
                ->order('Username');
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(10)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
	  
    public function getListaOrganizzazioni ($paged=null) {
        $select=$this->select()
                ->where("Ruolo='liv3'")
                ->order('Username');
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(10)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
	
    public function insertOrganizzazione($info) {
        $sede=$info['Citta'].'-'.$info['Via'].'-'.$info['Civico'];
        $dati = array( 'Username' => $info['Username'],
		    'Password' => $info['Password'],
		    'Email' => $info['Email'],
                    'Ruolo' => 'liv3',
                    'Descrizione' => $info['Descrizione'],
                    'Missione' => $info['Missione'],
                    'Telefono' => $info['Telefono'],
                    'Fax' => $info['Fax'],
                    'Sede' => $sede,
                    'Logo' => $info['Logo']
        );
        $insert=$this->insert($dati);
    }
	
    public function cancellaUtente($id) {
        $this->delete(array("Username = (?)" => $id));
    }
	
    public function cancellaOrganizzazione($id) {
        $this->delete(array("Username = (?)" => $id));
    }
}
