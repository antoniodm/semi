 <!DOCTYPE html>

 
 <style>

td, tr{
	
	text-align:center;

	vertical-align:middle;
	
}


</style>
 
 
 
 <?php

	require 'vendor/autoload.php';
	
	
	try{
		
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$id_sensore = (int)$_GET['id_sensore'];
 	
	$sensori = $client ->db_sensori->sensori;

	
	$misurazioni = $client ->db_misurazioni->misurazioni;
	
		
	$filter = ['id_sensore' => $id_sensore];
	
	$options = array("sort" => array("_id" => 1));
	
	$sensore = $sensori->findOne(['id_sensore' => $id_sensore]);
	
	
	
	$prima_misurazione = $misurazioni->findOne( $filter, $options );
 
	
	$options = array("sort" => array("_id" => -1));
 
	$ultima_misurazione = $misurazioni->findOne($filter, $options );
	
	} catch(Exception $e){
		
		die("Errore connessione al database MongoDB: " .$e->getMessage() );
		
	}
 
 ?>
 
 
 
<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<title> 

Sensore 

<?php

echo $id_sensore;

?>

</title>


<body>
<div align = "center">

	<table>
		<form action="/semi/sito/modifica_nome_seme.php?id_sensore=dario" method="get"">
		<input type="hidden" name="id_sensore" value="
		<?php
		echo $id_sensore;
		
		?>
		" />
		<tr>
			<td>
			<strong>
				<?php
					echo $_GET['id_sensore'];
				?>	
			</strong>
			</td>

		<tr>
			<td>
			<img src="DHT11_high.png" alt="dht11.png" >
			</td>
		<tr>
			<td>
				
				seme attuale: 
				<strong>
				<?php
					echo $sensore['pianta'];
			
				?>
				</strong>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo "sensore: ";
					if($sensore['attivo'] == true){
						echo "attivo  "; //verde
						echo "  <svg height=\"10\" width=\"10\">
								  <circle cx=\"5\" cy=\"5\" r=\"4\"  fill=\"green\" />
								</svg> " ;
					}
					else{
						echo "inattivo"; //rosso
						echo "  <svg height=\"10\" width=\"10\">
								  <circle cx=\"5\" cy=\"5\" r=\"4\"  fill=\"red\" />
								</svg> " ;
					}
				?>
			</td>
		</tr>
		<tr>
		<td>
		<?php
			echo "ID_ARDUINO: ";
			echo $sensore['id_arduino'];
			
		?>
		</td>
		</tr>
		<tr>
		<td>
		 prima misurazione: 
		<strong>
		<?php
		
			echo $prima_misurazione['data'];
			
		?>
		</strong>
		</td>
		</td>
		<tr>
		<td>
		ultima misurazione:
		<strong>
		<?php
		
			
			echo $ultima_misurazione['data'];
			
		?>
		</strong>
		</td>
		</tr>
		<tr>
		<td>
					modifiche nome: 

		</td>
		</tr>
		<tr>
		<td>
				<input type="text" name="nome_pianta" value=
				<?php
					echo "\"";
					echo $sensore['pianta'] ;
					echo "\"";
				?>
				>
		</tr>
		</td>
		<tr>
		<td>
		<input type="submit" value="Salva">
		</td>
		</tr>
		</form>

	</table>
</div>

<body>

<html>