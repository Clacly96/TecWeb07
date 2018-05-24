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
                    'validators' => array(array('StringLength',true, array(6,20)),
                                            array('Db_NoRecordExists', true, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Username'))),
                    ));
                        
                
                $this->addElement('password', 'Password', array(
                    'label' => 'Password',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(6,10)),
                                            array('identical', true, array('Password')))
                ));
                
                $this->addElement('text', 'Nome', array(
                    'label' => 'Nome',
                    'filters' => array('StringTrim'),
                    'required' => true, 
                    'validators' => array(array('StringLength',true, array(1,30))),
                    
                ));
                
                $this->addElement('text', 'Cognome', array(
                    'label' => 'Cognome',
                    'filters' => array('StringTrim'),
                    'required' => true, 
                    'validators' => array(array('StringLength',true, array(1,30))),
                    
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
                ));
                
                $this->addElement('text', 'Citta', array(
                    'label' => 'Citta',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,26))),
                ));
                
                $this->addElement('text', 'Via', array(
                    'label' => 'Via/Piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,30))),
                ));
                
                 $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,4))),
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
                ));

		$this->addElement('submit', 'add', array(
                    'label' => 'Registrati',
		));
                
                
        }
}
