<html>
	<head>
		<title>Modifica Sensore</title>
		<meta http-equiv="refresh" content="3;URL=/semi/sito/indexSemi.php">
	</head>
		<body>
			<p>

<?php

	require 'vendor/autoload.php';


	$id_sensore = (int)$_GET['id_sensore'];
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$sensori = $client->db_sensori->sensori;
	
	$misurazioni = $client ->db_misurazioni->misurazioni;

	
	$sensore = $sensori->findOne(['id_sensore' => $id_sensore]);
	
	$nome_pianta = (string)$sensore['pianta'];
	
	$db_archiviate = $client->db_archiviate; 
	
	$archiviate = $db_archiviate->$nome_pianta; //nuova collezione

	$filter = ['id_sensore' => $id_sensore];

	$options = array("sort" => array("_id" => 1)); //ordine crescente
	
	$cursor = $misurazioni->find($filter, $options);

	foreach($cursor as $misurazione){ //cancella ogni misurazioni con determinato id_sensore e la inserisce nella nuova collezione
			$result = $archiviate->insertOne(['pianta' => $nome_pianta, 'data' => $misurazione['data'], 'umidita' => $misurazione['umidita'], 'temperatura' => $misurazione['temperatura'] ]);
			$misurazioni->DeleteOne(['_id' => $misurazione['_id']]);
	}
	
	$query = ['id_sensore' => $id_sensore];
	$cambia = array('$set' => array('attivo' => false, 'pianta' => 'nessuna')); //aggiorna il sensore togliendo il nome della pianta e mettendo "attivo" a false
				
	$result = $sensori->updateOne( $query, $cambia);
				
	
	
	echo "archiviazione avvenuta con successo";


?>
				
			<p>
	</body>
</html>