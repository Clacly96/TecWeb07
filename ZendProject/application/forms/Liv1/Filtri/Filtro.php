<?php
class Application_Form_Liv1_Filtri_Filtro extends App_Form_Abstract
{
        protected $_catalogModel;
        protected $_userModel;
        
        public function init(){
            $this->_catalogModel= new Application_Model_Catalogo();
            $this->_userModel= new Application_Model_Utenza(); 
            $this->setMethod('post');
            $this->setName('filtroCatalogo');
            $this->setAction('');
            $this->setAttrib('enctype', 'application/x-www-form-urlencoded');
            
            $categorie = array();
		$cats = $this->_catalogModel->estraiCategorie();
		foreach ($cats as $cat) {
			$categorie[$cat -> Nome] = $cat->Nome;
		}
		$this->addElement('select', 'Nome', array(
                        'label' => 'Categoria',
                        'required' => false,
			'multiOptions' => $categorie,
                        'value' => null
		));
                
                $organizzazioni = array();
		$orgs = $this->_userModel->getOrg();
		foreach ($orgs as $org) {
			$organizzazioni[$org -> Username] = $org->Username;
		}
		$this->addElement('select', 'Username', array(
                        'label' => 'Organizzazioni',
                        'required' => false,
			'multiOptions' => $organizzazioni,
                        'value' => null
		));
                
                $luoghi = array();
		$luogs = $this->_catalogModel->estraiLuoghi();
		foreach ($luogs as $luogo) {
			$luoghi[$luogo->Luogo] = $luogo->Luogo;
		}
		$this->addElement('select', 'Luogo', array(
                        'label' => 'Luoghi',
                        'required' => false,
			'multiOptions' => $luoghi,
                        'value' => null
		));
                
                
                
                

             /*   $date = new Element_Date('appointment-date');
                $date->setLabel('Appointment Date');
                $date->setAttributes([
                    'min'  => '2012-01-01',
                    'max'  => '2020-01-01',
                    'step' => '1', // days; default step interval is 1 day
                ]);
                $date->setOptions([
                    'format' => 'Y-m-d',
                ]);

                
                $this->add($date);*/

                $this->addElement('submit', 'filtra', array(
                        'label' => 'Filtra Eventi',
		));
                
                

            
            
        }
    
    
}