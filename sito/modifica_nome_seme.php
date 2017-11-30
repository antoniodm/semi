<html>
	<head>
		<title>Modifica Sensore</title>
		<meta http-equiv="refresh" content="3;URL=/semi/sito/indexSensori.php">
	</head>
		<body>
			<p>
				<?php

				require 'vendor/autoload.php';
				
				$ipdatabase = "mongodb://localhost:27017";
				
				$client = new MongoDB\Client($ipdatabase);
				
				$nuovo_nome = $_GET['nome_pianta'];
			 
				$id_sensore = (int)$_GET['id_sensore'];
			 
				$sensori = $client ->db_sensori->sensori;
				
				$misurazioni = $client ->db_misurazioni->misurazioni;

				$query = ['id_sensore' => $id_sensore];
				$cambia = array('$set' => array('pianta' => $nuovo_nome));
				
				$result = $sensori->updateOne( $query, $cambia);
				


				echo "Modifica del nome del seme avvenuta con successo!";
				
				
				
				?>
				
			<p>
		</body>
</html>