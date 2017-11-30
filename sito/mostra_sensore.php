 <!DOCTYPE html>

 <?php

	require 'vendor/autoload.php';
	
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

	<table>
		<form action="/semi/sito/modifica_nome_seme.php?id_sensore=dario" method="get"">
		<input type="hidden" name="id_sensore" value="
		<?php
		echo $id_sensore;
		
		?>
		" />
		<tr>
			<td>
				<?php
					echo $_GET['id_sensore'];
				?>			
			</td>

		<tr>
			<td>
			<img src="DHT11_high.png" alt="dht11.png" >
			</td>
		<tr>
			<td>
				<?php
					echo 'seme attuale: ';
					echo $sensore['pianta'];
			
				?>
				<input type="text" name="nome_pianta" value=
				<?php
					echo "\"";
					echo $sensore['pianta'] ;
					echo "\"";
				?>
				>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo "sensore ";
					if($sensore['attivo'] == true)
						echo "attivo"; //verde
					else
						echo "inattivo"; //rosso
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
		<?php
		
			echo 'prima misurazione: ';
			echo $prima_misurazione['data'];
			
		?>
		</td>
		</td>
		<tr>
		<td>
		<?php
		
			echo 'ultima misurazione: ';
			echo $ultima_misurazione['data'];
			
		?>
		</td>
		</tr>
		<tr>
		<td>
		<input type="submit" value="Salva">
		</td>
		</tr>
		</form>

	</table>


<body>

<html>