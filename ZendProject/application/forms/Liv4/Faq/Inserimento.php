<?php
class Application_Form_Liv4_Faq_Inserimento extends App_Form_Abstract{
  

	public function init()
	{
		
		$this->setMethod('POST');
		$this->setName('inserimento');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                
                $this->addElement('text', 'Domanda', array(
                    'label' => 'Domanda',
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(5,100))),
                    'decorators' => $this->elementDecorators,
                    ));
                $this->addElement('text', 'Risposta', array(
                    'label' => 'Risposta',
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(5,200))),
                    'decorators' => $this->elementDecorators,
                    ));
                
                 $this->addElement('submit', 'inserisci', array(
                        'label' => 'Inserisci FAQ',
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
