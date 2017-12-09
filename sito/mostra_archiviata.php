<html>

<?php


	require 'vendor/autoload.php';


	$pianta = (string)$_GET['pianta'];
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$db_archiviate = $client->db_archiviate;
	
	$misurazioni_archiviate= $db_archiviate->$pianta;
	
	
	$filter = [];

	$options = array("sort" => array("_id" => 1)); //meglio farlo sulla data

	$ultima_misurazione = $misurazioni_archiviate->findOne($filter, $options);
	
	$options = array("sort" => array("_id" => -1)); //meglio farlo sulla data

	$prima_misurazione = $misurazioni_archiviate->findOne($filter, $options);
	

	
		
?>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<title> 

 

<?php

echo $pianta;

?>

</title>


<body>

	<table>
		<tr>
			<td>
				<?php
					echo $pianta;
				?>			
			</td>

		<tr>
			<td>
				<img src="seme_high.png" alt="seme" >
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
				<?php
					echo "prima misurazione: ";
					echo $prima_misurazione['data'];
				?>
			</td>
		</tr>
		</form>
		
		<tr>
			<td>
				<form action="/semi/sito/scarica_misurazione_archiviata.php" method="get"">
					<input type="submit" value="scarica misurazione">
					<input type="hidden" name="pianta" value="<?php echo $pianta;?>">
				</form>
			</td>
		<tr>
	</table>


<body>

<html>