<?php

class Application_Resource_Evento_Item extends Zend_Db_Table_Row_Abstract
{   
	public function init()
    {
    }
    
    public function scontato($evento) //ritorna 1 se il prodotto è in sconto (se c'è uno sconto e se la data attuale è maggiore della data di inizio sconto)
    {
        $data = new Zend_Date(Zend_Date::TIMESTAMP);
        if($evento->Sconto>0 && $data>=$evento->Data_Inizio_Sconto){
            return 1;
        }
        else{
            return 0;
        }
    }
    public function ottieniPrezzoScontato($evento)
    {
        $prezzo = $evento->Prezzo_Biglietto;
        if(scontato($evento)===true){
            $percSconto=$evento->Sconto;
            $sconto=$prezzo*$percSconto/100;
            $prezzo=round($prezzo - $sconto, 2); //arrotonda a due cifre decimali
        }
        return $prezzo;
    }
    
}
