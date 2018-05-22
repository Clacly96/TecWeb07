<?php
class Zend_View_Helper_AnteprimaEvento extends Zend_View_Helper_HtmlElement
{
	private $_tipo;
	
	public function AnteprimaEvento($evento, $tipo = 'anteprima', $link=null,$path=null)
	{
            $tag='hai sbagliato parametro tipo, metti o anteprima o singolo o scontato';
		if($tipo=='anteprima') $tag= '<li class="ev_li"><a href='.$this->view->url(array('controller' => 'liv1' , 'action' => 'catalogo', 'evento' => $evento->Id),'default',true).'><div class="ev_sfondo"> <div class="descev">Descrizione:<br>'. $evento->estraiDescrBreve() .'...</div><div class="przev"> Prezzo: '. $evento->ottieniPrezzo($evento) .'</div></div><img src="'. $this->view->baseUrl('/images/locandine/' . $evento->Locandina) .'"><div class="titoloev">'.$evento->Nome.'</div></a></li>';                   
                if($tipo=='scontato') $tag= '<li class="sconto_li"><a href="'.  $this->view->url(array('controller' => 'liv1' , 'action' => 'catalogo', 'evento' => $evento->Id),'default',true) .'"><div class="prezzi_sconto"><div class="titoloev">'.  $evento->Nome  .'</div> <div class="old_price">Prezzo:'. $evento->Prezzo_Biglietto .'euro</div><div class="new_price">Prezzo:'. $evento->ottieniPrezzo() .'euro</div><div class="sconto">Sconto:'.$evento->Sconto .'%</div></div><img src="'. $this->view->baseUrl('/images/locandine/' . $evento->Locandina).'"></a></li>';
                if($tipo=='singolo') { 
                    
                    $tag= '<div id="SingoloEvento"><img src="'.$this->view->baseUrl('/images/locandine/' . $evento->Locandina).'"> '
                    . '<div id="Nome"> Nome: '.$evento->Nome.'</div> ';
                    
                      if($evento->scontato()) $tag=$tag.'<div class="old_price">Vecchio prezzo:'.$evento->Prezzo_Biglietto.'</div>'. '<div><b> Sconto: </b>'.$evento->Sconto.'</div>' ;
                      
                  $tag=$tag .'<div> Prezzo: '.$evento->ottieniPrezzo().'</div> '
                          . '<div><b> Biglietti rimanenti: </b>'.$evento->Biglietti_Rimanenti.'</div>'
                    . '<div><b> Luogo:</b> '.$evento->Luogo.'</div> '
                    . '<div><b> Data:</b> '.$evento->Data_Ora.'</div> <br> '
                    . '<div><b> Descrizione: </b>'.$evento->Descrizione.'</div> '
                    . '<div><b> Programma: </b>'.$evento->Programma.'</div>'
                    . '<div><b> Organizzazione: </b>'.$evento->Organizzazione.'</div>'
                    . '<div><b> Acquisto il biglietto entro: </b>'.$evento->Data_Fine_Acquisto.'</div></div>';
                }
                return $tag;
	}
}