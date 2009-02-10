<?php

/**
 * MP class
 * 
 * Test comment
 * 
 * @author Matt Haynes
 */
class Mp {
	
	/**
	 * MP name
	 *
	 * @var string
	 */
	public $name;
	
	/**
	 * MP party
	 *
	 * @var string
	 */
	public $party;
	
	/**
	 * MP constituency
	 *
	 * @var string
	 */
	public $constituency;
	
	/**
	 * MP id
	 *
	 * @var string
	 */
	public $id;
	
	/**
	 * Create MP
	 *
	 * @param string $name
	 * @param string $party
	 * @param string $constituency
	 * @param string $id
	 */
	public function __construct($name, $party, $constituency, $id) {
		$this->name = $name;
		$this->party = $party;
		$this->constituency = $constituency;
		$this->id = $id;
	}
	
	/**
	 * Retrieve a list of all MPs
	 *
	 * @return array
	 */
	public static function findAll() {
		
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMPs', array('output' => 'xml'));
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		$results = array();
		
		foreach ($mpData['twfy']['match'] as $result) {
			
			$mp = new self($result['name'], $result['party'], $result['constituency'], $result['person_id']);
			array_push($results, $mp);
			
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
			
		$constituencyData = $api->query('getConstituencies', array('search' => str_replace(' ', '+',  $constituency), 'output' => 'xml'));
		
		$constituencyData = Zend_Json::decode(Zend_Json::fromXml($constituencyData));
		
		if (!isset($constituencyData['twfy']['match'])) {
			throw new MpFindException('Constituency not found');
		}
		
		$results = array();
		
		foreach ($constituencyData['twfy']['match'] as $constituency) {
			
			$constituencyName = (is_array($constituency)) ? $constituency['name'] : $constituency;
			$constituencyName = str_replace(' ', '+',  $constituencyName);
			$constituencyName = str_replace('&', '%26amp%3B',  $constituencyName);
			
			$mpData = $api->query('getMP', array('constituency' => $constituencyName, 'output' => 'xml'));
			$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
			
			if (isset($mpData['twfy']['error'])) {
				throw new MpException($mpData['twfy']['error']);
			}

			$mp = new self($mpData['twfy']['full_name'], $mpData['twfy']['party'], $mpData['twfy']['constituency'], $mpData['twfy']['person_id']);
			
			array_push($results, $mp);
				
		}
		
		return $results;
		 
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
		
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		if (isset($mpData['twfy']['error'])) {
			throw new MpFindException($mpData['twfy']['error']);
		}
		
		$mp = new self($mpData['twfy']['full_name'], $mpData['twfy']['party'], $mpData['twfy']['constituency'], $mpData['twfy']['person_id']);
		
		$results = array();
		array_push($results, $mp);
		
		return $results;
		
	}
	
	/**
	 * Get MP details by id
	 *
	 * @param string $id
	 */
	public static function findById($id) {
	
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMP', array('id' => $id, 'output' => 'xml'));
		
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		$mp = (array_key_exists(0, $mpData['twfy']['match'])) ? $mpData['twfy']['match'][0] : $mpData['twfy']['match'];
		
		return new self($mp['full_name'], $mp['party'], $mp['constituency'], $mp['person_id']);
		
	}
	
}

?>