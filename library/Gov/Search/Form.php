<?php

/**
 * Gov_Search_Form
 * 
 * @author Matt Haynes
 */
class Gov_Search_Form extends Zend_Form {
	
	public function init() {
		
		$form = $this;
    										
		$searchField = $form->createElement('text', 'searchField', array(
    												'label' => 'Search for you mp',
    												'allowEmpty' => false,
													'required' => true,
    											)
    										)->setErrorMessages(array('Please enter a constituency name or full UK postcode'));    										
    	
		$form->addElement($searchField);
    	$form->addElement('submit', 'Search', array('order' => 100));
    	
 	   	$form->setDecorators(array(array('ViewScript', array(
    							'viewScript' => '_searchForm.phtml',
 	   							'form' => $this
    						))));
    	
		$form->getElement('Search')->setIgnore(true);    						
    						
    	$form->setMethod('post');
    	$form->setAction('/mp/search/');
    	
    	foreach($form->getElements() as $element) {
    		$element->addFilters(array(new Zend_Filter_StringTrim(), new Zend_Filter_StripTags()));
    	}
    	
    	parent::init();
		
	}
	
}	


?>