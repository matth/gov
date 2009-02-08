<?php
/**
 * Constituency class
 * 
 * @author Matt Haynes
 */
class Constituency {
	
	/**
	 * Retrieve a list of all constituencies
	 *
	 * @return array
	 */
	public static function findAll() {
		
		$api = new Gov_TWFYAPI();
		$constituencyData = $api->query('getConstituencies', array('output' => 'xml'));
		return Zend_Json::decode(Zend_Json::fromXml($constituencyData));
	}
	
	/**
	 * Get constituency by name
	 *
	 * @param string $constituency
	 * @return array Constituencies matching string 
	 */
	public static function findByName($constituency) {
		
		$api = new Gov_TWFYAPI();
		$constituencyData = $api->query('getConstituencies', array('search' => str_replace(' ', '+',  $constituency), 'output' => 'xml'));
		
		return Zend_Json::decode(Zend_Json::fromXml($constituencyData));
		 
	}
}
?>