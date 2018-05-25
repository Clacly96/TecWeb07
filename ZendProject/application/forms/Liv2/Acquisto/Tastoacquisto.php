<?php
class Application_Form_Liv2_Acquisto_Tastoacquisto extends App_Form_Abstract
{
    protected $_userModel;
    protected $_catalogModel;

    public function init() {
        $this->_userModel= new Application_Model_Utenza();
        $this->_catalogModel= new Application_Model_Catalogo();
        $this->setMethod('post');
        $this->setName('TastoacquistoForm');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
        /*il tasto hidden è nel liv controller
        $this->addElement('hidden', 'evento', array(
                        'required' => false,
                        'value' => $IdEv,
                ));*/
        $this->addElement('submit', 'acquista', array(
                        'label' => 'Acquista',
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

