<?php
class Application_Form_Liv1_Ricerca_Ricerca extends App_Form_Abstract
{
   
       // protected $_catalogModel;
        
         public function init(){
           
           // $this->_catalogModel= new Application_Model_Catalogo();   da mettere se si decide che per categoria facciamo una select
            $this->setMethod('post');
            $this->setName('ricercaCatalogo');
            $this->setAction('');
            $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
            
           
              $this->addElement('text', 'Luogo', array(
                        'label' => 'Inserisci luogo evento da cercare',
                        'required' => false,
                        'value' => null
		));
            $this->addElement('text', 'Categoria', array(
                        'label' => 'Categoria',
                        'required' => false,
                        'value' => null
                ));
        
            $this->addElement('text', 'Descrizione', array(
                        'label' => 'Inserisci descrizione evento da cercare',
                        'required' => false,
                        'value' => null
		));
            $this->addElement('text', 'Data_Ora', array(
                        'label' => 'Inserisci data evento da cercare',
                        'required' => false,
                        'value' => null
		));
          
            
            $this->addElement('submit', 'ricerca', array(
                        'label' => 'Ricerca Eventi'
		));
}
}
        
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

