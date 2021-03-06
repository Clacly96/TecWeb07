<?php
class Application_Form_Liv2_Acquisto_FormAcquisto extends App_Form_Abstract
{
    protected $_userModel;
    protected $_catalogModel;

    public function init() {
        $this->_userModel= new Application_Model_Utenza();
        $this->_catalogModel= new Application_Model_Catalogo();
        $this->setMethod('post');
        $this->setName('formAcquisto');
        $this->setAction('');
        $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
        $IdEv = $this->getAttrib('evento');
        $Ev=$this->_catalogModel->estraiEventoPerId($IdEv);
        $this->addElement('text', 'Numero_Biglietti', array(
                        'label' => 'Numero di biglietti',
                        'required' => true,
                        'value' => 1,
                        'validators' => array('int',
                                                array('between',true,array('min' => 1,'max'=>$Ev->Biglietti_Rimanenti))),
                        'decorators' => $this->elementDecorators
		));
       
        $pagamenti=array();
        $pagamenti['Mastercard']='Mastercard';
        $pagamenti['Visa']='Visa';
        $pagamenti['PayPal']='PayPal';
        $pagamenti['Bonifico Bancario']='Bonifico Bancario';
        $this->addElement('select', 'Modalita_Pagamento', array(
                        'label' => 'Scegli la modalità di pagamento',
                        'required' => true,
			'multiOptions' => $pagamenti, // da validare correttamente con le modalità di pagamento che scegliamo noi
                        'value' => null,
                        'decorators' => $this->elementDecorators,
		));
        
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