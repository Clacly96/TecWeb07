<?php
class Application_Form_Liv3_Statistiche_Incassototale extends App_Form_Abstract{

	public function init()
	{
		
		$this->setMethod('post');
		$this->setName('incassototale');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                
                
                
                $this->addElement('text', 'Data_Inizio', array(
                    'label' => 'Data Inizio(AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    ));
                
                
                
                
                $this->addElement('text', 'Data_Fine', array(
                    'label' => 'Data Fine(AAAA-MM-GG)',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('Date',true)),
                    'decorators' => $this->elementDecorators,
                    ));
                
                
                
                $this->addElement('submit', 'inserisci', array(
                        'label' => 'Calcola Incasso Totale',
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

