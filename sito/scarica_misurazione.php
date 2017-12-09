<?php
header("Content-type: text/plain");
header("Content-Disposition:  filename=savethis.txt");

	
	
	require 'vendor/autoload.php';


	$id_sensore = (int)$_GET['id_sensore'];
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$db_misurazioni = $client->db_misurazioni;
	
	$misurazioni = $db_misurazioni->misurazioni;
	
	$filter = ['id_sensore' => $id_sensore];

	$options = array("sort" => array("_id" => 1)); //meglio farlo sulla data

	$cursore_misurazioni = $misurazioni->find($filter, $options);
	
	
	foreach($cursore_misurazioni as $misurazione){
		
		echo $misurazione['data']; echo ","; echo $misurazione['umidita']; echo ","; echo $misurazione['temperatura']; echo "\n";
	}

?>


