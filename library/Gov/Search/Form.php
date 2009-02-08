<?php

/**
 * Gov_Search_Form
 * 
 * @author Matt Haynes
 */
class Gov_Search_Form extends Zend_Form {
	
	public function init() {
		
		$form = $this;

    	$searchType = $form->createElement('radio', 'searchType', array(
    											'Label' => 'Search by',
    											'multiOptions' => array('constituency' => 'Constituency', 'postcode' => 'Postcode'), 
    											)
    										)
    										->setRequired(true)
    										->setErrorMessages(array('Please select you type of search'))
    										->setValue('constituency');
    										      	
    	$constituency = $form->createElement('text', 'constituency', array(
    												'label' => 'Constituency',
    												'allowEmpty' => false,
    												'validators' => array(new Gov_Validate_FieldDepends('searchType', 'constituency'))
    											)
    										)->setErrorMessages(array('Please enter your constituency name'));
    										
		$postcode = $form->createElement('text', 'postcode', array(
    												'label' => 'Postcode',
    												'allowEmpty' => false,
    												'validators' => array(new Gov_Validate_FieldDepends('searchType', 'postcode'))
    											)
    										)->setErrorMessages(array('Please enter your postcode'));    										
    	
		$form->addElement($searchType);
    	$form->addElement($constituency);
    	$form->addElement($postcode);
    	$form->addElement('submit', 'Search', array('order' => 100));
    	
 	   	$form->setDecorators(array(array('ViewScript', array(
    							'viewScript' => '_searchForm.phtml',
 	   							'form' => $this
    						))));
    	
    	$form->setMethod('post');
    	$form->setAction('/mp/search/');
    	
    	foreach($form->getElements() as $element) {
    		$element->addFilters(array(new Zend_Filter_StringTrim(), new Zend_Filter_StripTags()));
    	}
    	
    	parent::init();
		
	}
	
}	


?>