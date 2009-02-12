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
		
}

?>