<?php

/**
 * MpController - The controller class for MP Info
 * 
 * @author Matt Haynes
 */

require_once 'Zend/Controller/Action.php';

class MpController extends Zend_Controller_Action {

	/**
	 * Default action
	 */
	public function indexAction() {
		$this->_helper->redirector('list');
	}
	
	/**
	 * List all MPs
	 */
    public function listAction() {
        $this->view->form = $this->getSearchForm();
        $this->view->results = Mp::findAll();
    }
    
    /**
     * Search action
     */
    public function searchAction() {
    	
    	if (!$this->getRequest()->isPost()) {
    		$this->_helper->redirector('list');
    	} else {
			
    		$form = $this->getSearchForm();
    		$data = $this->getRequest()->getParams();
			$this->view->form = $form;

    		if ($form->isValid($data)) {
    			    			
    			try {
    				
    				$postcodeValidator = new Gov_Validate_Postcode();
    				
    				// Constituency search
    				if (!$postcodeValidator->isValid($form->getValue('searchField'))) {
    					
    					$results = Mp::findByConstituency($form->getValue('searchField'));
    					
    				} else {
    					
    					$results = Mp::findByPostcode($form->getValue('searchField'));
    				}
    				
    				$this->view->results = $results;
    				    				
    			} catch (MpFindException $e) {
    				$this->view->error = $e->getMessage();
    			}
    			
    		} 
    		
    	}
    	
    }
    
    /**
     * Show Action
     */
    public function showAction() {
    	
    	$id = $this->getRequest()->getParam('id');
    	
    	if (!$id) {
    		$this->_helper->redirector('list');
    	} else {
    		
    		if (is_numeric($id)) {
    			$this->view->mp = Mp::findById(intval($id));
    		} else {
    			throw new Gov_Exception_BadParam("Param is not an integer");
    		}

    	}
    	
    }
    
    /**
     * Creates a new Zend_Form for the search box
     *
     * @return Zend_Form
     */
    private function getSearchForm() {
    	
    	$form = new Gov_Search_Form();
    	
    	return $form;
    	
    }
        
}
