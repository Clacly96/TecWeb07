<?php
class Application_Form_Liv2_Modifica_FormModificadatiutente extends App_Form_Abstract
{
    protected $_utenzaModel;
    
    
    
    public function init() {
        
        
        $this->_utenzaModel= new Application_Model_Utenza();
        $this->setMethod('post');
        $this->setName('modificadatiutente');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
        
        $credenziali = Zend_Auth::getInstance()->getIdentity();
        $username=$credenziali['Username'];
        
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
                    'attribs'    => array('readonly' => 'readonly'),
                    'decorators' => $this->elementDecorators,
        ));
         
        $this->addElement('password', 'Password', array(
                    'label' => 'Password',
                    'filters' => array('StringTrim'),
                    'required' => false,
                    'validators' => array(array('StringLength',true, array(4,10)),
                                            array('identical', true, array('Password'))),
                    'decorators' => $this->elementDecorators,
        ));
        
        $nome=$this->_utenzaModel->getUtenteByUsername($username)->Nome;
        $this->addElement('text', 'Nome', array(
                    'label' => 'Nome',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $nome,
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
                    
        ));
                
        $cognome=$this->_utenzaModel->getUtenteByUsername($username)->Cognome;
        $this->addElement('text', 'Cognome', array(
                    'label' => 'Cognome',
                    'filters' => array('StringTrim'),
                    'value' => $cognome,
                    'required' => true, 
                    'validators' => array(array('StringLength',true, array(1,30))),
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
        
        $resid=$this->_utenzaModel->getUtenteByUsername($username)->Residenza;
        $residenza=explode("-", $resid);
        
            
        
        $citta=$residenza[0];
        $this->addElement('text', 'Citta', array(
                    'label' => 'Citta',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $citta,
                    'validators' => array(array('StringLength',true, array(1,26))),
                    'decorators' => $this->elementDecorators,
        ));
                
        if(empty($residenza[1])) {
            $via=' ';
        } else {
            $via=$residenza[1];
        }
        $this->addElement('text', 'Via', array(
                    'label' => 'Via/Piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'value' => $via,
                    'validators' => array(array('StringLength',true, array(1,30))),
                    'decorators' => $this->elementDecorators,
        ));
                
        if(empty($residenza[2])) {
            $civico=' ';
        } else {
            $civico=$residenza[2];
        }
        $this->addElement('text', 'Civico', array(
                    'label' => 'Numero civico',
                    'filters' => array('StringTrim'),
                    //'required' => true,
                    'value' => $civico,
                    'validators' => array(array('StringLength',true, array(1,4))),
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
