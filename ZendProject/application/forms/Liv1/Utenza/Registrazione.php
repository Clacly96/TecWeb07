<?php
class Application_Form_Liv1_Utenza_Registrazione extends App_Form_Abstract
{
	protected $_utenzaModel;

	public function init()
	{
		$this->_utenzaModel = new Application_Model_Utenza();
		$this->setMethod('post');
		$this->setName('registrazione');
		$this->setAction('');
		
                
		$this->addElement('text', 'Username', array(
                    'label' => 'Username',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(3,20)),
                                            array('Db_NoRecordExists', true, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Username'))),
                    'decorators' => $this->elementDecorators,
                    ));
                        
                
                $this->addElement('password', 'Password', array(
                    'label' => 'Password',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(4,20)),
                                            array('identical', true, array('Password'))),
                    'decorators' => $this->elementDecorators,
                ));
                
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome',
                    'filters' => array('StringTrim'),
                    'required' => true, 
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
                    
                ));
                
                $this->addElement('text', 'Cognome', array(
                    'label' => 'Cognome',
                    'filters' => array('StringTrim'),
                    'required' => true, 
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
                    
                ));
                
               
                $this->addElement('text', 'Email', array(
                    'label' => 'Email',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,30)),
                                            array('EmailAddress'),
                                            array('Db_NoRecordExists', false, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Email'))),
                    'decorators' => $this->elementDecorators,
                ));
                
                
                
                $this->addElement('text', 'Citta', array(
                    'label' => 'Citta',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,26))),
                    'decorators' => $this->elementDecorators,
                ));
                
                $this->addElement('text', 'Via', array(
                    'label' => 'Via/Piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
                ));
                
                 $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                   
                    'validators' => array(array('StringLength',true, array(1,4)),
                                            array('Int')),
                    'decorators' => $this->elementDecorators,
                ));            
                
                
                $this->addElement('text', 'Telefono', array(
                    'label' => 'Telefono',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(8,20)),
                                            array('Digits'),
                                            array('Db_NoRecordExists', false, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Telefono'))),
                    'decorators' => $this->elementDecorators,
                ));

		$this->addElement('submit', 'registrati', array(
                    'label' => 'Registrati',
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
