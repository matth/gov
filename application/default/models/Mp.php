<?php

/**
 * MP class
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
	 * Lon and lat string
	 *
	 * @var string
	 */
	public $lon;
	public $lat;
	
	/**
	 * Create MP
	 *
	 * @param string $name
	 * @param string $party
	 * @param string $constituency
	 * @param string $id
	 * @param string $lon
	 * @param string $lat
	 */
	public function __construct($name, $party, $constituency, $id, $lon, $lat) {
		$this->name = $name;
		$this->party = $party;
		$this->constituency = $constituency;
		$this->id = $id;
		$this->lon = $lon;
		$this->lat = $lat;
	}
		
}

?>