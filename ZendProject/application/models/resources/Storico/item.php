<?php
class Application_Resource_Storico_Item extends Zend_Db_Table_Row_Abstract
{
    public function init()
    {
    }
    public function totale($evento) {
        $dataOrdine=$this->Data_Ora;
        if($dataOrdine>$evento->Data_Inizio_Sconto)
        {
            $prezzo = $evento->Prezzo_Biglietto;
            $percSconto=$evento->Sconto;
            $sconto=$prezzo*$percSconto/100;
            $prezzo=round($prezzo - $sconto, 2);
        } else
        {
            $prezzo = $this->Prezzo_Biglietto;
        }
        $totale=$this->Numero_Biglietti*$prezzo;
        return $totale;
    }
}

