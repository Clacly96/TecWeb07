<?php
class Zend_View_Helper_AnteprimaEvento extends Zend_View_Helper_HtmlElement
{
	public function AnteprimaEvento($evento,  $tipo = 'anteprima', $liv='liv1')
	{
            $tag='hai sbagliato parametro tipo, metti o anteprima o singolo o scontato';
		if($tipo=='anteprima') {$tag= '<li class="ev_li">'
                        . '<a href='.$this->view->url(array('controller' => $liv , 'action' => 'catalogo', 'evento' => $evento->Id),'default',true).'>'
                        . '<div class="ev_sfondo"> '
                        . '<div class="descev">Descrizione:<br>'. $evento->estraiDescrBreve() .'...</div>'
                        . '<div class="przev"> Prezzo: '. $this->view->prezzoEventi($evento,true) .'</div>'
                        . '</div><img src="'. $this->view->baseUrl('/images/locandine/' . $evento->Locandina) .'">'
                        . '<div class="titoloev">'.$evento->Nome.'</div></a></li>';}

                if($tipo=='scontato') {$tag= '<li class="sconto_li">'
                        . '<a href="'.  $this->view->url(array('controller' => $liv , 'action' => 'catalogo', 'evento' => $evento->Id),'default',true) .'">'
                        . '<div class="prezzi_sconto">'
                        . '<div class="titoloev">'.  $evento->Nome  .'</div> '
                        . '<div class="old_price">Prezzo: '. $this->view->prezzoEventi($evento,false) .'</div>'
                        . '<div class="new_price">Prezzo: '. $this->view->prezzoEventi($evento,true) .'</div>'
                        . '<div class="sconto">Sconto: '.$evento->Sconto .'%</div>'
                        . '</div>'
                        . '<img src="'. $this->view->baseUrl('/images/locandine/' . $evento->Locandina).'"></a></li>';}

                if($tipo=='singolo') {

                    $tag= '<div id="SingoloEvento"> '
                        . '<h1>'.$evento->Nome.'</h1>'
                        . '<img src="'.$this->view->baseUrl('/images/locandine/' . $evento->Locandina).'"><div id="info_biglietti"> ';

                      if($evento->scontato()) {$tag=$tag.'<div class="old_price">Vecchio prezzo:'.$this->view->prezzoEventi($evento,false).'</div>'
                              . '<div><b> Sconto: </b>'.$evento->Sconto.'%</div>' ;}
                    $luogo=explode('-',$evento->Luogo);
                    $tag=$tag .'<div><b> Prezzo: </b>'.$this->view->prezzoEventi($evento,true).'</div> '
                        . '<div><b> Biglietti rimanenti: </b>'.$evento->Biglietti_Rimanenti.'</div></div>'
                        . '<div><b> Città: </b> '.$luogo[0].'</div> '
                        . '<div><b> Via: </b> '.$luogo[1].'</div> '
                        . '<div><b> Numero civico: </b> '.$luogo[2].'</div> '
                        . '<div><b> Data: </b> '.$evento->Data_Ora.'</div> <br><br> '
                        . '<div><b> Descrizione: </b>'.$evento->Descrizione.'</div><br> '
                        . '<div><b> Programma: </b>'.$evento->Programma.'</div><br><br>'
                        . '<div><b> Categoria: </b>'.$evento->Tipologia.'</div>'
                        . '<div><b> Organizzazione: </b>'.$evento->Organizzazione.'</div>'
                        . '<div><b> Acquista il biglietto entro: </b>'.$evento->Data_Fine_Acquisto.'</div>'
                        . '</div>';
                }
                return $tag;
	}
}
