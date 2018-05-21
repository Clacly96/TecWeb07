<?php

class Application_Resource_Evento_Item extends Zend_Db_Table_Row_Abstract
{   
	public function init()
    {
    }
    
    public function ottieniPrezzo($evento)
    {
        $data =Zend_Date::TIMESTAMP;
        $prezzo = $evento->Prezzo_Biglietto;
        if($evento->Sconto>0 && $data>=$evento->Data_Inizio_Sconto){
            $percSconto=$evento->Sconto;
            $sconto=$prezzo*$percSconto/100;
            $prezzo=round($prezzo - $sconto, 2); //arrotonda a due cifre decimali
        }
        return $prezzo;
    }
    
    public function estraiDescrBreve($evento)
    {
        $descrizione= $evento->Descrizione;
        return substr($descrizione,0,50);
    }
    
}
