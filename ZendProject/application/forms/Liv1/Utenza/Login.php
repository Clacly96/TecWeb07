<?php
class Application_Form_Liv1_Utenza_Login extends App_Form_Abstract
{
    protected $_userModel;
    public function init() {
        $this->_userModel= new Application_Model_Utenza();
        $this->setMethod('post');
        $this->setName('LoginForm');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
        
        $this->addElement('text', 'Username', array(
                        'label' => 'Username',
                        'required' => true,
                        'value' => "",
                        'decorators' => $this->elementDecorators,
                ));
        $this->addElement('password', 'Password', array(
                        'label' => 'Password',
                        'required' => true,
                        'value' => "",
                        'decorators' => $this->elementDecorators,
                ));
        $this->addElement('submit', 'login', array(
                        'label' => 'Accedi',
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