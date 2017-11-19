
<?php
require 'vendor/autoload.php'; // qui trovi le istruzioni su come impostare php e mongodb http://php.net/manual/en/mongodb.tutorial.library.php

$client = new MongoDB\Client("mongodb://localhost:27017"); //si connette al db
$mcollection = $client->semi_db->misuration_col; 
$scollection = $client->semi_db->sensors_col; 

$id_sensor = $_POST['id_sensor'];
$sens = $scollection->findOne([ 'id_sensor' => $id_sensor ]);

if (empty($sens))
	{
	$result = $scollection->insertOne( [ 'id_sensor' => $id_sensor, 'type' => NULL, 'code' => NULL]);
	}

	$id_sensor = $_POST['id_sensor'];
	$datetime = $_POST['datetime'];
	$humidity = $_POST['humidity'];
	$temperature = $_POST['temperature'];
	
	$result = $mcollection->insertOne( [ 'sensore' => $id_sensor, 'umidita' => $humidity, 'temperatura' => $temperature, 'data' => $datetime ] ); // qui fa l' inserimento
 
?>
