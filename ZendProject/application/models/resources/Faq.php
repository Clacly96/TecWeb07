<?php
class Application_Resource_Faq extends Zend_Db_Table_Abstract{
    protected $_name='faq';
    protected $_primary='Id';
    protected $_rowClass = 'Application_Resource_Faq_Item';
    
    	public function init()
    {
    }
    public function estraiFaqPerId($Id)  //chiedere se le faq sono direttamente visibili o occorre cliccarci
    {
        return $this->find($id)->current();
    }
    
    
        public function estraiFaq($paged=null)
    {
         $select = $this->select()->order('Id ASC');
         if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);   
			$paginator = new Zend_Paginator($adapter);  
			$paginator->setItemCountPerPage(4)
		          	  ->setCurrentPageNumber((int) $paged); 
			return $paginator;
		}
        return $this->fetchAll($select);
    }
}

