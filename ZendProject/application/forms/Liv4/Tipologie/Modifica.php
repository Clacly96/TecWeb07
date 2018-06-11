<?php
class Application_Form_Liv4_Tipologie_Modifica extends App_Form_Abstract{
 

	public function init()
	{
		
		$this->setMethod('post');
		$this->setName('modifica');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                $tipo = $this->getAttrib('tipo');
                
                
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome tipologia',
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(2,30)),array('Db_NoRecordExists', true, array(     //possono esistere due eventi con nome uguale?
                                                                            'table' => 'tipologia',
                                                                            'field' => 'Nome'))),                            
                    'decorators' => $this->elementDecorators,
                    'value' => $tipo,
                   
                    ));
                               
                $this->addElement('submit', 'modifica', array(
                        'label' => 'Modifica Tipologia',
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