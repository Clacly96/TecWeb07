<?php
class App_Form_Abstract extends Zend_Form
{   
        public $elementDecorators = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'),array('tag' => 'td', 'class' => 'td_element')),
		array(array('alias2' => 'HtmlTag'), array('tag' => 'td', 'class' => 'td_errors','openOnly' => true, 'placement' => 'append')),
		'Errors',
		array(array('alias3' => 'HtmlTag'), array('tag' => 'td', 'closeOnly' => true, 'placement' => 'append')),
        array('Label', array('tag' => 'td')),
        array(array('alias4' => 'HtmlTag'), array('tag' => 'tr')),
        );
        
        public $elementDecoratorsFiltro = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'),array('tag' => 'div', 'class' => 'td_element')),
		array(array('alias2' => 'HtmlTag'), array('tag' => 'div', 'class' => 'td_errors','openOnly' => true, 'placement' => 'append')),
		'Errors',
		array(array('alias3' => 'HtmlTag'), array('tag' => 'div', 'closeOnly' => true, 'placement' => 'append')),
        array('Label', array('tag' => 'div')),
        array(array('alias4' => 'HtmlTag'), array('tag' => 'div', 'class' => 'elemento')),
        );
        
        public $buttonDecoratorsFiltro = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'), array('tag' => 'div', 'class' => 'top_button')),
        array(array('alias2' => 'HtmlTag'), array('tag' => 'div', 'class' => 'elemento')),
    	);
    
	public $buttonDecorators = array(
        'ViewHelper',
        array(array('alias1' => 'HtmlTag'), array('tag' => 'td', 'class' => 'td_button')),
        array(array('alias2' => 'HtmlTag'), array('tag' => 'tr')),
    	);
    
	public $fileDecorators = array(
        'File',
        array(array('alias1' => 'HtmlTag'),array('tag' => 'td', 'class' => 'file')),
		array(array('alias2' => 'HtmlTag'), array('tag' => 'td', 'class' => 'td_errors', 'openOnly' => true, 'placement' => 'append')),
		'Errors',
		array(array('alias3' => 'HtmlTag'), array('tag' => 'td', 'closeOnly' => true, 'placement' => 'append')),
        array('Label', array('tag' => 'td')),
        array(array('alias4' => 'HtmlTag'), array('tag' => 'tr')),
        );
}