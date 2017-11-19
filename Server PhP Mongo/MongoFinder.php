<?php
require 'vendor/autoload.php';

//questo script l' ho fatto solo per vedere come funzionava il search, se funziona dovrebbe stamparti una pagina piena di misurazioni in base a quante ne hai fatte

//connessione al db in locale
$client = new MongoDB\Client("mongodb://localhost:27017");
//selezione della collezione da usare
$mcollection = $client->semi_db->misuration_col;
$scollection = $client->semi_db->sensors_col;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//Conto quante variabili sono passate come argomento nell'URL
	$nVar = count( $_GET );

	//ritorna gli id dei sensori attivi (impostare controllo su last_activity per controllo temporale)

	if ($nVar == 0){
		$result = $scollection->find();

		$arr = array();
   		foreach($result as $c){

	       	$temp = array("id_sensor" => $c["id_sensor"], "type" => $c["type"], "code" => $c["code"]);
	       	 array_push($arr, $temp);

		}

    	echo json_encode(array("sensors" => $arr));	

	}


	if ($nVar == 1) {
		$id = $_GET['id'];
		$result = $mcollection->find( [ 'sensore' => $id ] ); 
		//stampa il json formattato correttamente per l'app 
		$arr = array();
   		foreach($result as $c){

	       	$temp = array("id_sensor" => $c["sensore"], "humidity" => $c["umidita"], "temperature" => $c["temperatura"], "datetime" => $c["data"]);
	       	 array_push($arr, $temp);

		}

    	echo json_encode(array("result" => $arr));	

	}

	if ($nVar == 3) {

		$id = $_GET['id'];

		$data1 = $_GET['data1'];

		$data2 = $_GET['data2'];

		$rangeQuery = array('id_sensor' => $id, 'data' => array( '$gt' => $data1, '$lt' => $data2 ));

		$result = $mcollection->find($rangeQuery); 

		foreach($result as $c){

	       	$temp = array("id_sensor" => $c["sensore"], "humidity" => $c["umidità"], "temperature" => $c["temperatura"], "datetime" => $c["data"]);
	       	 array_push($arr, $temp);

		}

    	echo json_encode($arr);	

	}
}
?>
