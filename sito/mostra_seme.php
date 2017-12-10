<html>

<style>

td, tr{
	
	text-align:center;

	vertical-align:middle;
	
}


</style>


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


<div align = "center">
	<table text-align = "center" vertical-align = "middle" >
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
					echo 'ultima umidità misurata: ';
					echo $ultima_misurazione['umidita'];
			
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo 'ultima temperatura misurata: ';
					echo $ultima_misurazione['temperatura'];			
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				echo "sensore ";
					if($sensore['attivo'] == true){
					
						echo "attivo"; //verde
						echo "  <svg height=\"10\" width=\"10\">
								  <circle cx=\"5\" cy=\"5\" r=\"4\"  fill=\"green\" />
								</svg> " ;
					}
					else{
						
						echo "inattivo"; //rosso
						echo "  <svg height=\"10\" width=\"10\">
								  <circle cx=\"5\" cy=\"5\" r=\"4\"  fill=\"#e60000\" />
								</svg> " ;
					}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo "prima umidità misurata";
					echo $prima_misurazione['umidita'];
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					echo 'prima temperatura misurata: ';
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
				<form action="/semi/sito/scarica_misurazione.php" method="get"">
					<input type="submit" value="scarica misurazione">
					<input type="hidden" name= "id_sensore" value="
					<?php
						echo $id_sensore;
					?>">
				</form>
			</td>
		<tr>
	</table>
</div>

<body>

<html>