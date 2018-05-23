<?php
class Application_Form_Liv1_Ricerca_Ricerca extends App_Form_Abstract
{
    protected $_catalogModel;
   
        
         public function init(){
            $this->_catalogModel= new Application_Model_Catalogo();
            $this->setMethod('post');
            $this->setName('ricercaCatalogo');
            $this->setAction('');
            $this->setAttrib('enctype', 'multipart/form-data');
            
            $luoghi = array();
            $luogs = $this->_catalogModel->estraiLuoghi();
            $luoghi[' ']=null;
            foreach ($luogs as $luogo) {
		$luoghi[$luogo->Luogo] = $luogo->Luogo;
		}
            $this->addElement('select', 'Luogo', array(
                        'label' => 'Luoghi',
                        'required' => false,
			'multiOptions' => $luoghi,
                        'value' => null
		));
                
            $categorie = array();
            $cats = $this->_catalogModel->estraiCategorie();
            $categorie[' ']=null;
            foreach ($cats as $cat) {
			$categorie[$cat -> Nome] = $cat->Nome;
		}
            $this->addElement('select', 'Tipologia', array(
                        'label' => 'Categoria',
                        'required' => false,
			'multiOptions' => $categorie,
                        'value' => null
		));
            $this->addElement('text', 'Descrizione', array(
                        'label' => 'Descrizione',
                        'required' => false,
                        'value' => null
		));
        
            
            $this->addElement('text', 'Data_Ora', array(
                        'label' => 'Data',
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

