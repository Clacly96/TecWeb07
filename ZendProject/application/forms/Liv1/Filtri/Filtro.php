<?php
class Application_Form_Liv1_Filtri_Filtro extends App_Form_Abstract
{
        protected $_catalogModel;
        protected $_userModel;
        
        public function init(){
            $this->_catalogModel= new Application_Model_Catalogo();
            $this->_userModel= new Application_Model_Utenza(); 
            $this->setMethod('POST');
            $this->setName('filtroCatalogo');
            $this->setAction('');
            $this->setAttrib('enctype', 'multipart/form-data');
            
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
                        'decorators' => $this->elementDecoratorsFiltro,
		));
                
                $organizzazioni = array();
		$orgs = $this->_userModel->getOrg();
                $organizzazioni['']='Qualsiasi';
		foreach ($orgs as $org) {
			$organizzazioni[$org -> Username] = $org->Username;
		}
		$this->addElement('select', 'Username', array(
                        'label' => 'Organizzazioni',
                        'required' => false,
			'multiOptions' => $organizzazioni,
                        'value' => null,
                        'decorators' => $this->elementDecoratorsFiltro,
		));
                
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
                        'decorators' => $this->elementDecoratorsFiltro,
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
                        'decorators' => $this->elementDecoratorsFiltro,
		));
                
                $this->addElement('text', 'Anno', array(
                        'label' => 'Anno',
                        'required' => false,
                        'value' => '',
                        'validators' => array('int'),
                        'decorators' => $this->elementDecoratorsFiltro,
                    ));
                
                $this->addElement('submit', 'filtra', array(
                        'label' => 'Filtra Eventi',
                        'decorators' => $this->buttonDecoratorsFiltro,
		));
                $this->setDecorators(array(
			'FormElements',
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));
                
            
            
        }
    
    
}