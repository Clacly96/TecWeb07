<?php

class Application_Resource_Evento_Item extends Zend_Db_Table_Row_Abstract
{   
    public function init()
    {
    }
    public function scontato(){
        $data =Zend_Date::TIMESTAMP;
        if($this->Sconto>0 && $data>=$this->Data_Inizio_Sconto){
            return 1;
        }
        else {
            return 0;
        }
    }

    public function ottieniPrezzo()
    {
        $prezzo = $this->Prezzo_Biglietto;
        if($this->scontato()==true){
            $percSconto=$this->Sconto;
            $sconto=$prezzo*$percSconto/100;
            $prezzo=round($prezzo - $sconto, 2); //arrotonda a due cifre decimali
        }
        return $prezzo;
    }
    
    public function estraiDescrBreve()
    {
        $descrizione= $this->Descrizione;
        return substr($descrizione,0,50);
    }
    
}
