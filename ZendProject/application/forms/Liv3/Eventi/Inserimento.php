<?php
class Application_Form_Liv3_Eventi_Inserimento extends App_Form_Abstract{
    protected $_catalogModel;

	public function init()
	{
		$this->_catalogModel = new Application_Model_Catalogo();
		$this->setMethod('post');
		$this->setName('inserimento');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome evento',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(6,20)),
                                            array('Db_NoRecordExists', true, array(     //possono esistere due eventi con nome uguale?
                                                                            'table' => 'evento',
                                                                            'field' => 'Nome'))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $categorie=array();
                $cat=$this->_catalogModel->estraiCategorie();
                foreach ($cat as $categoria) {
                    $categorie[$categoria->Nome]=$categoria->Nome;
                }
                $this->addElement('select', 'Tipologia', array(
                    'label' => 'Tipologia',
                    'required' => true,
                    'multiOptions' => $categorie,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Data', array(
                    'label' => 'Data (AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    ));
                $this->addElement('text', 'Ora', array(
                    'label' => 'Ora (0-24)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>23))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Minuti', array(
                    'label' => 'Minuti (0-60)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>59))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Prezzo_Biglietto', array(
                    'label' => 'Prezzo',
                    'required' => true,
                    'filters' => array('LocalizedToNormalized'),
                    'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                    'decorators' => $this->elementDecorators,
		));
                
                $this->addElement('text', 'Citta', array(
                    'label' => 'Città',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Via', array(
                    'label' => 'Via/piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                    'required' => false,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('textarea', 'Descrizione', array(
                    'label' => 'Descrizione',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('textarea', 'Programma', array(
                    'label' => 'Programma',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    ));
                $this->addElement('text', 'Biglietti_Rimanenti', array(
                    'label' => 'Numero di biglietti',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('GreaterThan',true, array('min' => 0))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Sconto', array(
                    'label' => 'Percentuale di sconto',
                    'filters' => array('StringTrim'),
                    'required' => false,            
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>100))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Giorni_Sconto', array(
                    'label' => 'Numero di giorni da cui inizia lo sconto',
                    'filters' => array('StringTrim'),
                    'required' => false,                                            //da sistemare in qualche modo, perchè se viene inserito lo sconto deve essere inserito anche questo
                    'validators' => array('int',array('GreaterThan',true, array('min' => 0))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('text', 'Data_Fine_Acquisto', array(
                    'label' => 'Data di fine acquisto (AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    ));
                
                
                
                $this->addElement('file', 'Locandina', array(
			'label' => 'Locandina',
			'destination' => APPLICATION_PATH . '/../public/images/locandine',
			'validators' => array( 
                            array('Count', false, 1),
                            array('Size', false, 1024000),
                            array('Extension', false, array('jpg', 'gif')),
                            array('ImageSize', false,
                                    array('minwidth' => 150,             
                                          'maxwidth' => 360,
                                          'minheight' => 250,
                                          'maxheight' => 450)),
                            array('Db_NoRecordExists', true, array(     
                                            'table' => 'evento',
                                            'field' => 'Locandina'))),             
                        'decorators' => $this->fileDecorators,
			));
                
                $this->addElement('textarea', 'Mappa', array(
                    'label' => 'Inserire iframe di Google Maps',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('submit', 'inserisci', array(
                        'label' => 'Inserisci Evento',
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

