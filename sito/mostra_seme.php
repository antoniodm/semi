<html>

<?php


	require 'vendor/autoload.php';


	$id_sensore = (int)$_GET['id_sensore'];
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$sensori = $client->db_sensori->sensori;
	
	$misurazioni = $client ->db_misurazioni->misurazioni;
	
	
	$sensore = $sensori->findOne(['id_sensore' => $id_sensore]);	
	
	$seme = $sensore['pianta'];
	

	$filter = ['id_sensore' => $id_sensore];

	$options = array("sort" => array("_id" => 1)); //meglio farlo sulla data

	$ultima_misurazione = $misurazioni->findOne($filter, $options);
	
	$options = array("sort" => array("_id" => -1)); //meglio farlo sulla data

	$prima_misurazione = $misurazioni->findOne($filter, $options);
	

	
		
?>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<title> 

Seme 

<?php

echo $seme;

?>

</title>


<body>

	<table>
		<form action="/semi/sito/archivia_misurazione.php" method="get""> 
		<input type="hidden" name="id_sensore" value="
		<?php
			echo $id_sensore;
		?>
		" />
		<tr>
			<td>
				<?php
					echo $seme;
				?>			
			</td>

		<tr>
			<td>
				<img src="seme_high.png" alt="seme" >
			</td>
		<tr>
			<td>
				<?php
					echo 'ultima umidità: ';
					echo $ultima_misurazione['umidita'];
			
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo 'ultima temperatura: ';
					echo $ultima_misurazione['temperatura'];			
				?>
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
					echo "umidità iniziale ";
					echo $prima_misurazione['umidita'];
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo 'temperatura iniziale: ';
					echo $ultima_misurazione['temperatura'];			
		?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="archivia Seme">
			</td>
		</tr>
		</form>
		
		<tr>
			<td>
				<form action="/semi/sito/download_misurazione.php" method="get"">
					<input type="submit" value="scarica misurazione">
				</form>
			</td>
		<tr>
	</table>


<body>

<html>