<?php
require 'vendor/autoload.php';

//questo script l' ho fatto solo per vedere come funzionava il search, se funziona dovrebbe stamparti una pagina piena di misurazioni in base a quante ne hai fatte


$client = new MongoDB\Client("mongodb://localhost:27017");


$collection = $client->test_database->test_collection;


$result = $collection->find( [ 'sensore' => '1' ] ); //fa una ricerca in base al sensore con ID = 1 e gli viene restituito un iteratore

foreach ($result as $entry) { //scorre l' iteratore e stampa
    echo 'umidità: ', $entry['umidità'], ' - temperatura: ', $entry['temperatura'], ' - data: ' , $entry['data'], "\r\n";
}
?>
