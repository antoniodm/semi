
<?php
require 'vendor/autoload.php'; // qui trovi le istruzioni su come impostare php e mongodb http://php.net/manual/en/mongodb.tutorial.library.php

$client = new MongoDB\Client("mongodb://localhost:27017"); //si connette al db

$misurazioni = $client->db_misurazioni->misurazioni;
$sensori = $client->db_sensori->sensori;



$id_arduino = $_POST['id_arduino'];
$id_sensor = $_POST['id_sensor'];
$datetime = $_POST['datetime'];
$humidity = $_POST['humidity'];
$temperature = $_POST['temperature'];

$result = $misurazioni->insertOne(  [ 'id_arduino' => $id_arduino , 'sensore' => $id_sensor, 'umidità' => $humidity, 'temperatura' => $temperature, 'data' => $datetime ] ); // qui fa l' inserimento

$sensorCheck = $sensori->findOne( [ 'id' => $id_sensor ] );

if($sensorCheck == null){
	$sensori->insertOne(['id_arduino' => $id_arduino, 'id' => $id_sensor, 'nome pianta' => 'INDEFINITO', 'attivo' => 'si' ]);
}	
	


echo "Inserted with Object ID '{$result->getInsertedId()}'"; //qui stampa l' id dell' inserimento
?>
