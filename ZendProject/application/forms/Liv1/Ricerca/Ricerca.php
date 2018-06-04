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
            $luoghi['']='Qualsiasi';
            foreach ($luogs as $luogo) {
		$luoghi[$luogo] = $luogo;
		}
            $this->addElement('select', 'Luogo', array(
                        'label' => 'Luoghi',
                        'required' => false,
			'multiOptions' => $luoghi,
                        'value' => null,
                        'decorators' => $this->elementDecorators,
		));
                
            $categorie = array();
            $cats = $this->_catalogModel->estraiCategorie();
            $categorie['']='Qualsiasi';
            foreach ($cats as $cat) {
			$categorie[$cat -> Nome] = $cat->Nome;
		}
            $this->addElement('select', 'Tipologia', array(
                        'label' => 'Categoria',
                        'required' => false,
			'multiOptions' => $categorie,
                        'value' => null,
                        'decorators' => $this->elementDecorators,
		));
            $this->addElement('text', 'Descrizione', array(
                        'label' => 'Descrizione',
                        'required' => false,
                        'value' => null,
                        'decorators' => $this->elementDecorators,
		));
        
            
            $mesi=array();
                    $mesi[''] = 'Qualsiasi';
                    $mesi[1] = 'Gennaio';
                    $mesi[2] = 'Febbraio';
                    $mesi[3] ='Marzo';
                    $mesi[4] = 'Aprile';
                    $mesi[5]='Maggio';
                    $mesi[6]='Giugno';
                    $mesi[7]='Luglio';
                    $mesi[8]='Agosto';
                    $mesi[9]='Settembre';
                    $mesi[10]='Ottobre';
                    $mesi[11]='Novembre';
                    $mesi[12]='Dicembre';
                $this->addElement('select', 'Mese', array(
                        'label' => 'Mese',
                        'required' => false,
			'multiOptions' => $mesi,
                        'value' => null,
                        'decorators' => $this->elementDecorators,
		));
                
                $this->addElement('text', 'Anno', array(
                        'label' => 'Anno',
                        'required' => false,
                        'value' => '',
                        'validators' => array('int'),
                        'decorators' => $this->elementDecorators,
                    ));
          
            
            $this->addElement('submit', 'ricerca', array(
                        'label' => 'Ricerca Eventi',
                        'decorators' => $this->buttonDecorators,
		));
            $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));
    }
}