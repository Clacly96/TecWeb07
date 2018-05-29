<?php
class Application_Form_Liv2_Partecipazione_Tastopartecipazione extends App_Form_Abstract
{
    protected $_userModel;
    protected $_catalogModel;

    public function init() {
        $this->_userModel= new Application_Model_Utenza();
        $this->_catalogModel= new Application_Model_Catalogo();
        $this->setMethod('post');
        $this->setName('TastopartecipazioneForm');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
       
        $this->addElement('submit', 'Partecipazione', array(
                        'label' => 'Parteciperò',
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


