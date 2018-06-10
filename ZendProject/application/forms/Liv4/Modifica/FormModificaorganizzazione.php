<?php
class Application_Form_Liv4_Modifica_FormModificaorganizzazione extends App_Form_Abstract
{
    protected $_utenzaModel;
    
    public function init() {
        
        $this->_utenzaModel= new Application_Model_Utenza();
        $this->setMethod('post');
        $this->setName('Modifica');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
        
       
        $username = $this->getAttrib('organizzazione');
        $this->addElement('text', 'Username', array(
                    'label' => 'Username',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(3,10)),
                                            array('Db_NoRecordExists', true, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Username',
                                                                            'exclude' => array ('field' => 'Username', 'value' => $username)))),
                    'value' => $username,                                                     
                    'decorators' => $this->elementDecorators,
        ));
         
        $this->addElement('password', 'Password', array(
                    'label' => 'Password',
                    'filters' => array('StringTrim'),
                    'validators' => array(array('StringLength',true, array(4,10)),
                                            array('identical', true, array('Password'))),
                    'decorators' => $this->elementDecorators,
        ));
                
        $email=$this->_utenzaModel->getUtenteByUsername($username)->Email;   
        $this->addElement('text', 'Email', array(
                    'label' => 'Email',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $email,
                    'validators' => array(array('StringLength',true, array(1,30)),
                                            array('EmailAddress'),
                                            array('Db_NoRecordExists', false, array(
                                                                            'table' => 'utente',
                                                                            'field' => 'Email',
                                                                            'exclude' => array ('field' => 'Email', 'value' => $email)))),
                    'decorators' => $this->elementDecorators,
        ));
        
        $desc=$this->_utenzaModel->getUtenteByUsername($username)->Descrizione;
        $this->addElement('textarea', 'Descrizione', array(
            'label' => 'Descrizione', 
            'filters' => array('StringTrim'),
            'required' => true,
            'value' => $desc,
            'validators' => array(array('StringLength',true, array(1,2000)),
                                    array('Db_NoRecordExists', false, array(
                                            'table' => 'utente',
                                            'field' => 'Descrizione',
                                            'exclude' => array ('field' => 'Descrizione', 'value' => $desc)))),
            'decorators' => $this->elementDecorators,
        ));
        
        $miss=$this->_utenzaModel->getUtenteByUsername($username)->Missione;
        $this->addElement('textarea', 'Missione', array(
            'label' => 'Missione', 
            'filters' => array('StringTrim'),
            'required' => true,
            'value' => $miss,
            'validators' => array(array('StringLength',true, array(1,1000)),
                                    array('Db_NoRecordExists', false, array(
                                            'table' => 'utente',
                                            'field' => 'Missione',
                                            'exclude' => array ('field' => 'Missione', 'value' => $miss)))),
            'decorators' => $this->elementDecorators,
        ));
        
        $telefono=$this->_utenzaModel->getUtenteByUsername($username)->Telefono;
        $this->addElement('text', 'Telefono', array(
            'label' => 'Telefono',
            'filters' => array('StringTrim'),
            'required' => true,
            'value' => $telefono,
            'validators' => array(array('StringLength',true, array(8,20)),
                                            array('Digits'),
                                            array('Db_NoRecordExists', false, array(
                                                'table' => 'utente',
                                                'field' => 'Telefono',
                                                'exclude' => array ('field' => 'Telefono', 'value' => $telefono)))),
            'decorators' => $this->elementDecorators,
        ));
        
        $fa=$this->_utenzaModel->getUtenteByUsername($username)->Fax;
        if(empty($fa)) {
            $fax= '';
        } else {
            $fax=$fa;
        }
        //$fax=$this->_utenzaModel->getUtenteByUsername($username)->Fax;
        $this->addElement('text', 'Fax', array(
            'label' => 'Fax',
            'filters' => array('StringTrim'),
            'required' => true,
            'value' => $fax,
            'validators' => array(array('StringLength',true, array(8,20)),
                                            array('Digits'),
                                            array('Db_NoRecordExists', false, array(
                                                'table' => 'utente',
                                                'field' => 'Fax',
                                                'exclude' => array ('field' => 'Fax', 'value' => $fax)))),
            'decorators' => $this->elementDecorators,
        ));
        
        $sed=$this->_utenzaModel->getUtenteByUsername($username)->Sede;
        $sede=explode("-", $sed);
        
        $citta=$sede[0];
        $this->addElement('text', 'Citta', array(
                    'label' => 'Citta',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $citta,
                    'validators' => array(array('StringLength',true, array(1,26))),
                    'decorators' => $this->elementDecorators,
        ));
                
        if(empty($sede[1])) {
            $via=' ';
        } else {
            $via=$sede[1];
        }
        $this->addElement('text', 'Via', array(
                    'label' => 'Via/Piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $via,
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
        ));
                
        if(empty($sede[2])) {
            $civico=' ';
        } else {
            $civico=$sede[2];
        }
        $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                    //'required' => true,
                    'value' => $civico,
                    'validators' => array(array('StringLength',true, array(1,4))),
                    'decorators' => $this->elementDecorators,
        ));    
        
        $logo=$this->_utenzaModel->getUtenteByUsername($username)->Logo;
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
                        'value' => $logo,
	));
        
        $this->addElement('submit', 'Modifica', array(
                    'label' => 'Modifica',
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

