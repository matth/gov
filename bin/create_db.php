<?php 

	set_include_path('.' . PATH_SEPARATOR . '../library' . PATH_SEPARATOR . '../application/default/models/' . PATH_SEPARATOR . get_include_path());
	
	require_once "Zend/Loader.php"; 
	
	Zend_Loader::registerAutoload();

	system('rm findyourmp-db.sqlite');
	
	if ($db = new SQLiteDatabase('findyourmp-db.sqlite')) {
		
		$q = @$db->query('SELECT requests FROM mps WHERE id = 1');
        
		// Fetch data
		fwrite(STDOUT, "Fetching data from theyworkforyou.com API \n");
		
		$api = new Gov_TWFYAPI();
		$mpData = $api->query('getMPs', array('output' => 'xml'));
		$mpData = Zend_Json::decode(Zend_Json::fromXml($mpData));
		
		// Make DB table and insert data
		fwrite(STDOUT, "Inserting data into table \n");
		$db->queryExec('CREATE TABLE mps (id INTEGER AUTOINCREMENT PRIMARY KEY, person_id INTEGER, name STRING, constituency STRING);');
		
		foreach ($mpData['twfy']['match'] as $mp) {
			$db->queryExec("INSERT INTO mps (person_id, name, constituency) VALUES ({$mp['person_id']}, \"{$mp['name']}\", \"{$mp['constituency']}\");");
		}
		
		$db->close();
		
    } else {
        die($err);
    }


?>