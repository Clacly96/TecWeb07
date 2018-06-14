<?php
class Application_Form_Liv4_Faq_Modifica extends App_Form_Abstract{
 
protected $_faqModel;
	public function init()
	{
		$this->_faqModel = new Application_Model_Faq();
		$this->setMethod('post');
		$this->setName('modifica');
		$this->setAction('');
                $this->setAttrib('enctype', 'multipart/form-data');
                $IdFaq = $this->getAttrib('faq');
                $faq=$this->_faqModel->estraiFaqPerId($IdFaq);
                
                
                $this->addElement('textarea', 'Domanda', array(
                    'label' => 'Domanda',
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(5,100))),                            
                    'decorators' => $this->elementDecorators,
                    'value' => $faq->Domanda,
                   
                    ));
                
                 $this->addElement('textarea', 'Risposta', array(
                    'label' => 'Risposta',
                    'required' => true,
                    'validators' => array(array('StringLength',true, array(5,200))),                            
                    'decorators' => $this->elementDecorators,
                    'value' => $faq->Risposta,
                   
                    ));
                        
                               
                $this->addElement('submit', 'modifica', array(
                        'label' => 'Modifica Faq',
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