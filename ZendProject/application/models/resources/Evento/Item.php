<?php

class Application_Resource_Evento_Item extends Zend_Db_Table_Row_Abstract
{   
	public function init()
    {
    }
    
    public function ottieniPrezzoScontato($evento)
    {
        $prezzo = $evento->Prezzo_Biglietto;
        $percSconto=$evento->Sconto;
        $sconto=$prezzo*$percSconto/100;
        $prezzo=round($prezzo - $sconto, 2); //arrotonda a due cifre decimali
        return $prezzo;
    }
    
}
