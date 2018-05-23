<?php
class Zend_View_Helper_PrezzoEventi extends Zend_View_Helper_Abstract
{
    public function prezzoEventi($evento,$flag=true) {
        $moneta = new Zend_Currency();
        return ($flag)? $moneta->toCurrency($evento->ottieniPrezzo()):$moneta->toCurrency($evento->Prezzo_Biglietto);
    }
}
