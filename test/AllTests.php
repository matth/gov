<?php
/**
 * AllTests - A Test Suite for your Application 
 * 
 * @author
 * @version 
 */
require_once 'PHPUnit/Framework/TestSuite.php';

set_include_path('.' . PATH_SEPARATOR . '../library' . PATH_SEPARATOR . '../application/default/models/' . PATH_SEPARATOR . get_include_path());

require_once './lib/Gov/Validate/PostcodeTest.php';

/**
 * AllTests class - aggregates all tests of this project
 */
class AllTests extends PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ('AllTests');
		
		$this->addTestSuite('Gov_Validate_PostcodeTest');
	
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}

