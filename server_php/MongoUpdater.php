
<?php
require 'vendor/autoload.php'; // qui trovi le istruzioni su come impostare php e mongodb http://php.net/manual/en/mongodb.tutorial.library.php

$client = new MongoDB\Client("mongodb://localhost:27017"); //si connette al db
$mcollection = $client->db_misurazioni->misurazioni; 
$scollection = $client->db_sensori->sensori; 

//salvo i valori delle rispettive chiavi e li converto nei tipi corretti
$id_sensore = (int)$_POST['id_sensore'];
$id_arduino = (int)$_POST['id_arduino'];

$umidita = (float)$_POST['umidita'];
$temperatura = (float)$_POST['temperatura'];
$data = $_POST['data'];

$data = new MongoDB\BSON\UTCDateTime( $data ); //risolvere il problema noto della data indietro di una ora

$cursore = $scollection->findOne([ 'id_sensore' => $id_sensore ]);

//se il sensore non esiste inserisce un nuovo sensore nel db db_sensori
//ma come gli assegno il nome della pianta?
if (empty($cursore)){
	$result = $scollection->insertOne( [ 'id_sensore' => $id_sensore, 'id_arduino' => $id_arduino, 'attivo' => true, 'pianta' => 'indefinito']);
}

	
$result = $mcollection->insertOne( [ 'id_sensore' => $id_sensore, 'umidita' => $umidita, 'temperatura' => $temperatura, 'data' => $data ] ); 
 
?>
