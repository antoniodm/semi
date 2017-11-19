<?php
require 'vendor/autoload.php';

//questo script l' ho fatto solo per vedere come funzionava il search, se funziona dovrebbe stamparti una pagina piena di misurazioni in base a quante ne hai fatte


$client = new MongoDB\Client("mongodb://localhost:27017");


$collection = $client->db_misurazioni->misurazioni;

$sensori = $client->db_sensori->sensori;



$result = $collection->find( [ 'sensore' => '1' ] ); //fa una ricerca in base al sensore con ID = 1 e gli viene restituito un iteratore

$sensorCheck = $sensori->findOne( [ 'id' => '1' ] );

if($sensorCheck == null){
	echo 'è null';
	$sensori->insertOne(['id' => $id_sensor, 'nome pianta' => 'INDEFINITO', 'attivo' => 'si' ]);
}	

foreach ($result as $entry) { //scorre l' iteratore e stampa
    echo 'umidità: ', $entry['umidità'], ' - temperatura: ', $entry['temperatura'], ' - data: ' , $entry['data'], "\r\n";
}
?>
