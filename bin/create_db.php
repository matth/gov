<?php 

	set_include_path('.' . PATH_SEPARATOR . '../library' . PATH_SEPARATOR . '../application/default/models/' . PATH_SEPARATOR . get_include_path());
	
	require_once "Zend/Loader.php"; 
	
	Zend_Loader::registerAutoload();

	$dbName = 'findyourmp.db';
	
	system('rm ' . $dbName);
	
	if ($db = new PDO('sqlite:' . $dbName)) {
		
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		// Fetch data
		fwrite(STDOUT, "Fetching data from theyworkforyou.com API \n");
		
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMPs', array('output' => 'xml'));
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		// Make DB table and insert data
		fwrite(STDOUT, "Inserting data into table \n");
		$db->query('CREATE TABLE mps (id INTEGER PRIMARY KEY, person_id INTEGER, name STRING, constituency STRING, party STRING, lat STRING, lon STRING);');
		
		foreach ($mpData['twfy']['match'] as $mp) {
			
			fwrite(STDOUT, "Fetching lon and lat for {$mp['constituency']} \n");
			
			$constituency = str_replace(' ',  '+', $mp['constituency']);
			$constituency = str_replace('&',  '%26', $constituency);
			
			$latLong = $api->query('getGeometry', array('output' => 'xml', 'name' => $constituency));
			$latLong = Zend_Json::decode(Zend_Json::fromXml($latLong));
			
			$lon = $latLong['twfy']['centre_lon'];
			$lat = $latLong['twfy']['centre_lat'];
									
			$db->query("INSERT INTO mps (person_id, name, constituency, party, lon, lat) VALUES ({$mp['person_id']}, \"{$mp['name']}\", \"{$mp['constituency']}\", \"{$mp['party']}\", \"$lat\", \"$lon\");");
		}
		
		$db->query('CREATE INDEX person_id ON mps (person_id)');
				
    } else {
        die($err);
    }


?>