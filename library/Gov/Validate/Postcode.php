<?php
/**
 * Validates that a string conforms to the UK Postcode format 
 * 
 * 
 * @uses     Zend_Validate_Abstract
 * @category Gov
 * @package  Gov_Validate
 * @author   Matt Haynes 
 */

require_once 'Zend/Validate/Abstract.php';

class Gov_Validate_Postcode extends Zend_Validate_Abstract {
	
	/**
	 * Test postcode is of a valid format
	 *
	 * @param string $postcode
	 */
	public function isValid($postcode) {
		
		$pattern = '(GIR 0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]|[A-HK-Y][0-9]([0-9]|[ABEHMNPRV-Y]))|[0-9][A-HJKS-UW])[\ ]?[0-9][ABD-HJLNP-UW-Z]{2})';
		$match = preg_match($pattern, strtoupper($postcode));
		
		if ($match > 0) {
			return true;
		} else {
			return false;
		}
		
	}
	
}
?>