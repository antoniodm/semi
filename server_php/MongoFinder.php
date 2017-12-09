<?php
require 'vendor/autoload.php';

//questo script l' ho fatto solo per vedere come funzionava il search, se funziona dovrebbe stamparti una pagina piena di misurazioni in base a quante ne hai fatte

//connessione al db in locale
$client = new MongoDB\Client("mongodb://localhost:27017");
//selezione della collezione da usare
$mcollection = $client->db_misurazioni->misurazioni;
$scollection = $client->db_sensori->sensori; 

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	//Conto quante variabili sono passate come argomento nell'URL
	$nVar = count( $_GET );

	//ritorna gli id dei sensori attivi (impostare controllo su last_activity per controllo temporale)

	if ($nVar == 0){
		$result = $scollection->find();

		$arr = array();
   		foreach($result as $c){

   		    $temp = array("id_sensor" => $c["id_sensore"], "type" => $c["pianta"], "code" => $c["id_arduino"], "active" => $c["attivo"]);
	       	 array_push($arr, $temp);

		}

    	echo json_encode(array("sensors" => $arr));	

	}


	if ($nVar == 1) {
		$id = $_GET['id'];

		$result = $mcollection->find( [ 'id_sensore' => (int)$id ] ); 

		//stampa il json formattato correttamente per l'app 
		$arr = array();
   		foreach($result as $c){
	       	$temp = array("id_sensor" => $c["id_sensore"], "humidity" => $c["umidita"], "temperature" => $c["temperatura"], "datetime" => $c["data"]);
	       	 array_push($arr, $temp);

		}

    	echo json_encode(array("result" => $arr));	

	}
	
	if ($nVar == 2) {
	    $id = (int)$_GET['id'];
	    $name = $_GET['setName'];
	    
	    $query = ['id_sensore' => $id];
	    $cambia = array('$set' => array('pianta' => $name));
	    
	    $result = $scollection->updateOne( $query, $cambia);
	    
	    echo "200";
	    
	    
	}


	if ($nVar == 3 && $_GET['archive'] != NULL) {

	    $id_arduino = $_GET['code'];
	    
	    $id_sensore = (int)$_GET['id'];
	    
	    
	    $sensore = $scollection->findOne(['id_sensore' => $id_sensore]);
	    
	    $nome_pianta = (string)$sensore['pianta'];
	    
	    $db_archiviate = $client->db_archiviate;
	    
	    $archiviate = $db_archiviate->$nome_pianta; //nuova collezione
	    $filter = ['id_sensore' => $id_sensore];
	    $options = array("sort" => array("_id" => 1)); //ordine crescente
	    $cursor = $mcollection->find($filter, $options);
	    foreach($cursor as $misurazione){ //cancella ogni misurazioni con determinato id_sensore e la inserisce nella nuova collezione
	        $result = $archiviate->insertOne(['pianta' => $nome_pianta, 'data' => $misurazione['data'], 'umidita' => $misurazione['umidita'], 'temperatura' => $misurazione['temperatura'] ]);
	        $mcollection->DeleteOne(['_id' => $misurazione['_id']]);
	    }
	    
	    $query = ['id_sensore' => $id_sensore];
	    $cambia = array('$set' => array('attivo' => false, 'pianta' => 'indefinito')); //aggiorna il sensore togliendo il nome della pianta e mettendo "attivo" a false
	    
	    $result = $scollection->updateOne( $query, $cambia);
	    
	    
	    
	    echo "200";
	    
	   /* $result = $mcollection->find( [ 'id_sensore' => (int)$id_sensore ] );
	    $temp1 = array("id_sensore" => $id_sensore, "id_arduino" => $id_sensore );
	    $arr = array();
	    array_push($arr, $temp1);
	    foreach($result as $c){
	        $temp = array( "umidita" => $c["umidita"], "temperatura" => $c["temperatura"], "data" => $c["data"]);
	        array_push($arr, $temp);
	    }
	    // creating object of SimpleXMLElement
	    $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><misurazione></misurazione>");
	    // function call to convert array to xml
	    array_to_xml($arr,$xml);
	    
	    //saving generated xml file
	    echo $xml;*/
        
	}
	 

	
}

function array_to_xml($arr, &$xml) {
    foreach($arr as $key => $value) {
        if(is_array($value)) {
            $key = is_numeric($key) ? "item$key" : $key;
            $subnode = $xml->addChild("$key");
            array_to_xml($value, $subnode);
        }
        else {
            $key = is_numeric($key) ? "item$key" : $key;
            $xml->addChild("$key","$value");
        }
    }
}

/*if ($nVar == 3) {

$id = $_GET['id'];

$data1 = $_GET['data1'];

$data2 = $_GET['data2'];

$rangeQuery = array('id_sensor' => $id, 'data' => array( '$gt' => $data1, '$lt' => $data2 ));

$result = $mcollection->find($rangeQuery);

foreach($result as $c){

$temp = array("id_sensor" => $c["id_sensore"], "humidity" => $c["umidita"], "temperature" => $c["temperatura"], "datetime" => $c["data"]);
array_push($arr, $temp);

}*/

?>
