<?php
class Application_Form_Liv4_Tipologie_Inserimento extends App_Form_Abstract{
    

	public function init()
	{
		
		$this->setMethod('POST');
		$this->setName('inserimento');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome tipologia',
                    'required' => true,
                    'validators' => array(array('Db_NoRecordExists', true, array(  
                                                                            'table' => 'tipologia',
                                                                            'field' => 'Nome'))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                 $this->addElement('submit', 'inserisci', array(
                        'label' => 'Inserisci Tipologia',
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

