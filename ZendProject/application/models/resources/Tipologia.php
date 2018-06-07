<?php

class Application_Resource_Tipologia extends Zend_Db_Table_Abstract
{
    protected $_name    = 'Tipologia';
    protected $_primary  = 'Nome';
    protected $_rowClass = 'Application_Resource_Tipologia_Item';
    
	public function init()
    {
    }
    
	
    public function estraiCategorie()// Estrae tutte le categorie Categorie ordinate per nome
    {
	$select = $this->select()->order('Nome');
        return $this->fetchAll($select);
    }
    
    public function insertTipologia($nome)
    {
    	$this->insert($nome);
    }
    
    public function cancellazioneTipologia($nome)
    {
        $this->delete(array("Nome=(?)"=>$nome));
    }
 
    public function modificaTipologia($vecchio,$nuovo)
    {
        $tipo=array(
            'Nome' => $nuovo
        );
      
        $where=array(
            'Nome=(?)'=>$vecchio
        );
        $this->update($tipo, $where);
    }
}
