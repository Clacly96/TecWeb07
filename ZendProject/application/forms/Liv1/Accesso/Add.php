<?php
class Application_Form_Liv1_Accesso_Add extends App_Form_Abstract
{
	protected $_utenzaModel;

	public function init()
	{
		$this->_utenzaModel = new Application_Model_Utenza();
		$this->setMethod('post');
		$this->setName('registrazione');
		$this->setAction('');
		
                $username=array();
                $utenti=$this->_utenzaModel->getUtenti();
                foreach ($utenti as $us) {
                    $username[$us->Username] = $us->Username;
                }
		$this->addElement('text', 'Username', array(
                    'label' => 'Username',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(6,20)),
                                            array('Db_NoRecordExists', false, $username)),
                                            
                    
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
                
                $email=array();
                $emails=$this->_utenzaModel->getEmails();
                foreach ($emails as $em) {
                    $email[$em->Email] = $em->Email;
                }
                $this->addElement('text', 'Email', array(
                    'label' => 'Email',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,30)),
                                            array('EmailAddress'),
                                            array('Db_NoRecordExists', false, $email)),
                ));
                
                $this->addElement('text', 'Residenza', array(
                    'label' => 'Citta',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,25))),
                ));
                
                $this->addElement('text', 'Residenza', array(
                    'label' => 'Via/Piazza',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(1,25))),
                ));
                
                $this->addElement('text', 'Residenza', array(
                    'label' => 'Numero Civico',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(0,5)),
                                            array('Int')),
                ));
                
                $this->addElement('hidden', 'Ruolo', array(
                    'value' => 'utente',
                ));
                
                $telefono=array();
                $phones=$this->_utenzaModel->getTelefoni();
                foreach ($phones as $phone) {
                    $telefono[$phone->Telefono] = $phone->Telefono;
                }
                $this->addElement('text', 'Telefono', array(
                    'label' => 'Telefono',
                    'filters' => array('StringTrim'),
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(8,20)),
                                            array('Digits'),
                                            array('Db_NoRecordExists', false, $telefono)),
                ));

		$this->addElement('submit', 'add', array(
                    'label' => 'Registrati',
		));
                
                
        }
}
