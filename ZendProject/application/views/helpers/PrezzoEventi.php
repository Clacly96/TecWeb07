<?php
class Zend_View_Helper_PrezzoEventi extends Zend_View_Helper_Abstract
{
    public function prezzoEventi($evento) {
        $moneta = new Zend_Currency();
        $prezzo=$moneta->toCurrency($evento->ottieniPrezzo());
        return $prezzo;
    }
}
