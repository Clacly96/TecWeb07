<?php
class Application_Resource_Utente extends Zend_Db_Table_Abstract {
    protected $_name = 'utente';
    protected $_primary = 'Username';
    protected $_rowClass = 'Application_Resource_Utente_Item';
    
    public function init() 
    {
    }
    
    public function getOrgById($id) 
    {
        return $this->find($id)->current();
    }
    
    public function getOrg($paged=null)
    {
        $select = $this->select()
                ->where('Ruolo = organizzazione OR Ruolo = Organizzazione')
                ->order('Nome');
        if($paged != null) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
            $paginator = new Zend_Paginator($adapter);
            $paginator ->setItemCountPerPage(10)
                    ->setCurrentPageNumber((int) $paged);
            return $paginator;
        }
        return $this->fetchAll($select);
    }
}
