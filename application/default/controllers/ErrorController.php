<?php

/**
 * ErrorController - The default error controller class
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class ErrorController extends Zend_Controller_Action
{

    /**
     * This action handles  
     *    - Application errors
     *    - Errors in the controller chain arising from missing 
     *      controller classes and/or action methods
     */
    public function errorAction() {
    	
        $this->errors = $this->_getParam('error_handler');
        
        $this->view->errors = $this->errors;
        
        if ($this->errors->type == Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER ||
        	$this->errors->type == Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION ||
        	$this->errors->exception instanceof Gov_Exception_BadParam)
        {
        	return $this->fourOhFourAction();
        } else {
        	return $this->fiveHundredAction();
        }
        
    }
    
    public function fourOhFourAction() {
    	// 404 error -- controller or action not found                
		$this->getResponse()->setHttpResponseCode(404);
        $this->view->title = 'HTTP/1.1 404 Not Found';
    	$this->render('error');
    }
    
    public function fiveHundredAction() {
    	$this->getResponse()->setHttpResponseCode(500);
    	$this->view->title = 'Application Error';
        $this->view->message = $this->errors->exception;
        $this->view->errors = $this->errors;
        $this->render('error');
    }
}
