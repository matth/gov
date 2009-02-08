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
    			
    			$results = array();
    			
    			try {
    				
    				// Constituency search
    				if ($this->getRequest()->getParam('searchType') == 'constituency') {
    					
    					$constituency = Constituency::findByName($form->getValue('constituency'));
    					$this->view->dump = $constituency;
    					// Any errors ?
    					if (!isset($constituency['twfy']['match']) || isset($constituency['twfy']['error'])) {
    						return $this->view->error = 'Constituency not found';
    					} else {
    						
    						if (isset($constituency['twfy']['match']['name'])) {
    							// Single result
    								$mp = Mp::findByConstituency($constituency['twfy']['match']['name']);
	    							array_push($results, $mp);
    						} else {
								// Multiple results
	    						foreach ($constituency['twfy']['match'] as $constituency) {
	    							$mp = Mp::findByConstituency($constituency['name']);
	    							array_push($results, $mp);
	    						}
    							
    						}
    						
    					}
    					
    				} else {
    					
    					$mp = Mp::findByPostcode($form->getValue('postcode'));
    					
    					if (isset($mp['twfy']['error'])) {
    						$this->view->error = $mp['twfy']['error'];
    						return;
    					} else {
    						array_push($results, $mp);
    					}
    					
    				}
    				
    				$this->view->results = $results;
    				
    				    				
    			} catch (Exception $e) {
    				
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
