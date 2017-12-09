<?php
header("Content-type: text/plain");
header("Content-Disposition:  filename=savethis.txt");

	
	
	require 'vendor/autoload.php';


	$pianta = (string)$_GET['pianta'];
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$db_archiviate = $client->db_archiviate;
	
	$misurazioni_archiviate= $db_archiviate->$pianta;
	
	
	$filter = [];

	$options = []; //meglio farlo sulla data

	$cursore_misurazioni = $misurazioni_archiviate->find($filter, $options);
	
	
	foreach($cursore_misurazioni as $misurazione){
		
		echo $misurazione['data']; echo ","; echo $misurazione['umidita']; echo ","; echo $misurazione['temperatura']; echo "\n";
	}

?>


