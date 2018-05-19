<?php

class Application_Resource_Tipologia extends Zend_Db_Table_Abstract
{
    protected $_name    = 'tipologia';
    protected $_primary  = 'Nome';
    protected $_rowClass = 'Application_Resource_Tipologia_Item';
    
	public function init()
    {
    }
    
	
    public function estraiCategorie()// Estrae tutte le categorie Categorie ordinate per nome
    {
		$select = $this->select()->order('name');
        return $this->fetchAll($select);
    }
 
}