<?php
/**
 * Gov_Search_iew_Helper_SearchForm
 * 
 * @author Matt Haynes
 */
class Zend_View_Helper_SearchForm extends Zend_View_Helper_Abstract {
	
	/**
	 * Get search form
	 *
	 * @return Gov_Search_Form
	 */
	public function searchForm() {
		
		$form = new Gov_search_Form();
		
		$front = Zend_Controller_Front::getInstance();
		$request = $front->getRequest();
		
		if ($request->isPost()) {
			$form->isValid($request->getParams());
		}
		
		return $form;
	}
	
	/**
	 * Strategy pattern
	 *
	 * @return Gov_Search_Form
	 */
	public function direct() {
		return $this->searchForm();
	}

}

?>