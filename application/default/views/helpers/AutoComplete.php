<?php
/**
 * ConstituencyAutoComplete, makes javascript for autocomplete 
 * 
 * @author Matt Haynes
 */

class Zend_View_Helper_AutoComplete extends Zend_View_Helper_Abstract {
	
    public function autoComplete($results) {
        
    	$data = array();
    	
    	foreach ($results as $result) {
    		$firstLetter = strtolower(substr($result->constituency, 0, 1));
    		
    		if (!isset($data[$firstLetter])) {
    			$data[$firstLetter] = array();
    		}
    		
    		$mpData = array($result->constituency, $result->name, $result->party, $result->lon, $result->lat);
    		
    		array_push($data[$firstLetter], $mpData);
    		
    	}
    	
    	return Zend_Json::encode($data);
    	
    }
	
}

?>