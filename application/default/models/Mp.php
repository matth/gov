<?php

/**
 * MP class
 * 
 * @author Matt Haynes
 */
class Mp {
	
	/**
	 * Retrieve a list of all MPs
	 *
	 * @return array
	 */
	public static function findAll() {
		
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMPs', array('output' => 'xml'));
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		// Normalize results
		$results = array();
		foreach ($mpData['twfy']['match'] as $mp) {
			$mp['full_name'] = $mp['name'];
			$mpArray = array('twfy' => $mp);
			array_push($results, $mpArray);
		}
		
		return $results;
	}
	
	/**
	 * Get MP Details by constituency name
	 *
	 * @param string $constituency
	 * @return array MP Info 
	 */
	public static function findByConstituency($constituency) {
		
		$api = new Gov_TWFYAPI();
		$constituency = str_replace(' ', '+',  $constituency);
		$constituency = str_replace('&', '%26amp%3B',  $constituency);
			
		$mpData = $api->query('getMP', array('constituency' => $constituency, 'output' => 'xml'));
		
		return Zend_Json::decode(Zend_Json::fromXml($mpData));
		 
	}
	
	/**
	 * Find MP by postcode
	 *
	 * @param string $postcode
	 * @return array MP Info
	 */
	public static function findByPostcode($postcode) {
		
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMP', array('postcode' => str_replace(' ', '+',  $postcode), 'output' => 'xml'));
		
		return Zend_Json::decode(Zend_Json::fromXml($mpData));
		
	}
	
	/**
	 * Get MP details by id
	 *
	 * @param string $id
	 */
	public static function findById($id) {
	
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMP', array('id' => $id, 'output' => 'xml'));
		
		return Zend_Json::decode(Zend_Json::fromXml($mpData));
		
	}
	
}

?>