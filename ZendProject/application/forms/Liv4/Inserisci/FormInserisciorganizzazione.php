<?php
class Application_Form_Liv4_Inserisci_FormInserisciorganizzazione extends App_Form_Abstract
{
    protected $_utenzaModel;
    
    public function init() {
	$this->_utenzaModel = new Application_Model_Utenza();
	$this->setMethod('post');
	$this->setName('inserisciorganizzazione');
	$this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
                
        $this->addElement('text', 'Username', array(
            'label' => 'Username',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(6,20)),
                                            array('Db_NoRecordExists', true, array(  
                                                                            'table' => 'utente',
                                                                            'field' => 'Username'))),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('password', 'Password', array(
            'label' => 'Password',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(6,10))),
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
                                                                            'field' => 'Email'
                                        ))),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'Descrizione', array(
            'label' => 'Descrizione', 
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,2000))),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'Missione', array(
            'label' => 'Missione', 
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,1000))),
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
                                                                            'field' => 'Telefono',
                                ))),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('text', 'Fax', array(
            'label' => 'Fax',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(8,20)),
                                            array('Digits'),
                                            array('Db_NoRecordExists', false, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Fax',
                                ))),
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
                
        $this->addElement('file', 'Logo', array(
	    'label' => 'Logo',
            'destination' => APPLICATION_PATH . '/../public/images/loghi',
	    'validators' => array( 
                            array('Count', false, 1),
                            array('Size', false, 1024000),
                            array('Extension', false, array('jpg', 'gif')),
                            array('Db_NoRecordExists', true, array(     
                                            'table' => 'utente',
                                            'field' => 'Logo'))),             
            'decorators' => $this->fileDecorators,
	));
                
        $this->addElement('submit', 'Inserisci', array(
            'label' => 'Inserisci',
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

