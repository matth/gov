<?php
/**
 * Interface for MpMapper
 * 
 * @author Matt Haynes
 */
interface MpMapperInterface {

	/**
	 * Retreive an array of all Mp objects
	 * 
	 * @return array An array of Mp objects
	 */
	public function findAll();
		
	/**
	 * Retreive an array of all Mp objects matching constituency
	 *
	 * @param string $constituency
	 * @return array An array of all matching Mp objects
	 */
	public function findByConstituency($constituency);	
	
	/**
	 * Find Mp object by id
	 * 
	 * @param string $id
	 * @return Mp
	 */
	public function findById($id);
	
	/**
	 * Find Mp object by postcode
	 *
	 * @param string $postcode
	 * @return array An array of all matching Mp objects, just the one
	 */
	public function findByPostcode($postcode);
	
}
?>