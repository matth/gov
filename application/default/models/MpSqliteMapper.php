<?php

class MpSqliteMapper implements MpMapperInterface {
	
	/**
	 * Database driver
	 *
	 * @var PDO
	 */
	private $dbh;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		
		$this->dbh = Zend_Db::factory('PDO_SQLITE', array(
			'dbname' => APPLICATION_DIRECTORY . '/../bin/findyourmp.db'
		));
		
		$this->dbh->getConnection()->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );		
		
	}
	
	/**
	 * Retreive an array of all Mp objects
	 *
	 * @return array An array of all Mp objects
	 */
	public function findAll() {
		
		$results = array();
		
		$dbResults = $this->dbh->fetchAll('SELECT * FROM mps');
		
		if (count($dbResults) == 0) {
			throw new MpFindException("Cannot find any MP data in DB");
		} 
		
		foreach ($dbResults as $mpData) {
			$mp = $this->getMp($mpData);
			array_push($results, $mp);
		}
		
		return $results;
		
	}
	
	/**
	 * Retreive an array of all Mp objects matching constituency
	 *
	 * @param string $constituency
	 * @return array An array of all matching Mp objects
	 */
	public function findByConstituency($constituency) {
		
		$results = array();
		
		$dbResults = $this->dbh->fetchAll('SELECT * FROM mps WHERE constituency LIKE ?', '%' . $constituency . '%');
		
		if (count($dbResults) == 0) {
			throw new MpFindException("Cannot find constituency");
		} 
		
		foreach ($dbResults as $mpData) {
			$mp = $this->getMp($mpData);
			array_push($results, $mp);
		}
		
		return $results;
		
	}
	
	/**
	 * Find Mp object by id
	 *
	 * @param string $id
	 * @return Mp 
	 */
	public function findById($id) {
		
		$dbResults = $this->dbh->fetchAll('SELECT * FROM mps WHERE person_id = ?', $id);

		if (count($dbResults) == 0) {
			throw new MpFindException("Cannot find MP by id: $id");
		} 
		
		return $this->getMp($dbResults[0]);
		
	}
	
	/**
	 * Find Mp object by postcode
	 *
	 * @param string $postcode
	 * @return array An array of all matching Mp objects, just the one
	 */
	public function findByPostcode($postcode) {
		
		$api = new Gov_TWFYAPI();

		$mpData = $api->query('getMP', array('postcode' => str_replace(' ', '+',  $postcode), 'output' => 'xml'));
		
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		if (isset($mpData['twfy']['error'])) {
			throw new MpFindException($mpData['twfy']['error']);
		}
				
		$results = array();
		array_push($results, $this->findById($mpData['twfy']['person_id']));
		
		return $results;
		
	}
	
	/**
	 * Get Mp object from result set
	 *
	 * @param array $mpData
	 * @return Mp
	 */
	private function getMp($mpData) {
		return new Mp($mpData['name'], $mpData['party'], $mpData['constituency'], $mpData['person_id'], $mpData['lon'], $mpData['lat']);
	}
	
}

?>