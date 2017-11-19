
<?php
require 'vendor/autoload.php'; // qui trovi le istruzioni su come impostare php e mongodb http://php.net/manual/en/mongodb.tutorial.library.php

$client = new MongoDB\Client("mongodb://localhost:27017"); //si connette al db
$collection = $client->test_database->test_collection; 

//test_database è il nome di uno dei database nella sessione di mongodb (un database mongodb può avere più database al suo interno)
//test_collection è la collezione
//in qualunque caso se non sono già presenti nel db te li crea da solo

//questa parte l' ho presa pari dal vecchio aggiornando le variabili
if (true) {
	$id_sensor = $_POST['id_sensor'];
	$datetime = $_POST['datetime'];
	$humidity = $_POST['humidity'];
	$temperature = $_POST['temperature'];
	
	$result = $collection->insertOne( [ 'sensore' => $id_sensor, 'umidità' => $humidity, 'temperatura' => $temperature, 'data' => $datetime ] ); // qui fa l' inserimento

} 



echo "Inserted with Object ID '{$result->getInsertedId()}'"; //qui stampa l' id dell' inserimento
?>
