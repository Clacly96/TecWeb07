<?php
class Application_Form_Liv3_Eventi_Modifica extends App_Form_Abstract{
    protected $_catalogModel;

	public function init()
	{
		$this->_catalogModel = new Application_Model_Catalogo();
		$this->setMethod('post');
		$this->setName('modifica');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                $IdEv = $this->getAttrib('evento');
                
                $evento=$this->_catalogModel->estraiEventoPerId($IdEv);
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome evento',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(6,40))),                            
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Nome,
                    'attribs'    => array('readonly' => 'readonly'),
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
                    'value' => $evento->Tipologia,
                    ));
                
                $data_ora=explode(' ',$evento->Data_Ora);
                $data=$data_ora[0];
                $this->addElement('text', 'Data', array(
                    'label' => 'Data (AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    'value' => $data,
                    ));
                $ora_minuti=explode(':',$data_ora[1]);
                $ora=$ora_minuti[0];
                $minuti=$ora_minuti[1];
                $this->addElement('text', 'Ora', array(
                    'label' => 'Ora (0-24)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>23))),
                    'decorators' => $this->elementDecorators,
                    'value' => $ora,
                    ));
                
                $this->addElement('text', 'Minuti', array(
                    'label' => 'Minuti (0-60)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>59))),
                    'decorators' => $this->elementDecorators,
                    'value' => $minuti,
                    ));
                
                $this->addElement('text', 'Prezzo_Biglietto', array(
                    'label' => 'Prezzo',
                    'required' => true,
                    'filters' => array('LocalizedToNormalized'),
                    'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Prezzo_Biglietto,
		));
                $luogo=explode('-',$evento->Luogo);
    
                $this->addElement('text', 'Citta', array(
                    'label' => 'Città',
                    'filters' => array('StringTrim','StringToLower'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    'value' => $luogo[0],
                    ));
                
                $this->addElement('text', 'Via', array(
                    'label' => 'Via/piazza',
                    'filters' => array('StringTrim','StringToLower'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    'value' => $luogo[1],
                    ));
                
                $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                    'required' => false,
                    'decorators' => $this->elementDecorators,
                    'value' => $luogo[2],
                    ));
                
                $this->addElement('textarea', 'Descrizione', array(
                    'label' => 'Descrizione',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Descrizione,
                    ));
                
                $this->addElement('textarea', 'Programma', array(
                    'label' => 'Programma',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Programma,
                    ));
                $this->addElement('text', 'Biglietti_Rimanenti', array(
                    'label' => 'Numero di biglietti',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array('int',array('GreaterThan',true, array('min' => -1))),
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Biglietti_Rimanenti,
                    ));
                
                $this->addElement('text', 'Sconto', array(
                    'label' => 'Percentuale di sconto',
                    'filters' => array('StringTrim'),
                    'required' => false,            
                    'validators' => array('int',array('between',true,array('min' => 0,'max'=>100))),
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Sconto
                    ));
                
                $datasc=new Zend_Date($evento->Data_Inizio_Sconto);
                $dataev=new Zend_Date($data_ora[0]);
                $numgiorni=round($dataev->sub($datasc)->toValue() / 86400);     //toValue restituisce il valore in secondi, quindi va diviso per ricavarne i giorni
                
                $this->addElement('text', 'Giorni_Sconto', array(
                    'label' => 'Numero di giorni da cui inizia lo sconto',
                    'filters' => array('StringTrim'),
                    'required' => false,                                            
                    'validators' => array('int',array('GreaterThan',true, array('min' => -1))),
                    'decorators' => $this->elementDecorators,
                    'value' => $numgiorni,
                    ));
                
                $this->addElement('text', 'Data_Fine_Acquisto', array(
                    'label' => 'Data di fine acquisto (AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Data_Fine_Acquisto,
                    ));
                
                $this->addElement('checkbox', 'elimina_locandina', array(
                    'label' => 'Seleziona per rimuovere la locandina',
                    'decorators' => $this->elementDecorators,
                    ));
                
                $this->addElement('file', 'Locandina', array(
			'label' => 'Locandina',
			'destination' => APPLICATION_PATH . '/../public/images/locandine',
			'validators' => array( 
			array('Count', false, 1),
			array('Size', false, 1024000),
			array('Extension', false, array('jpg', 'gif')),
                        array('Db_NoRecordExists', true, array(     
                                        'table' => 'evento',
                                        'field' => 'Locandina'))),                    
                        'decorators' => $this->fileDecorators,
                        'value' => $evento->Locandina,
			));
                $this->addElement('textarea', 'Mappa', array(
                    'label' => 'Inserire iframe di Google Maps',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'decorators' => $this->elementDecorators,
                    'value' => $evento->Mappa,
                    ));
                
                $this->addElement('submit', 'modifica', array(
                        'label' => 'Modifica Evento',
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