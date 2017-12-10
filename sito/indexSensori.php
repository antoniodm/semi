<html>
(click sul sensore per mostrare il dettaglio)
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 25;
	
}


li {
	padding: 10;
	
}


table{
	
	font-family: arial, sans-serif;
	
	border-collapse: collapse;
	width: 50%;
	
	
}


td, th{
	border: 1px solid grey;
	text-align: left;
	padding: 10px;
	
	
}



tr:nth-child(even){
		background-color: #dddddd

	
	
}
</style>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

	<body>
		<ul>
		<?php


		require 'vendor/autoload.php';

		try{
			
		$client = new MongoDB\Client("mongodb://localhost:27017");		
		
		$sensori = $client->db_sensori->sensori;

		
		if( ( $cursor = iterator_to_array( $sensori->find( [ ] )) ) == null ){
			
				die("Nessun sensore presente nel database");
			
		} 
	
	
		$keys1 = iterator_to_array($cursor[0]);
		
		$keys1[] = array_keys($keys1);
	
		}catch (Exception $e){
		
			die("Errore nella connessione al server MongoDB: " .$e->getMessage() );
			
		}
	
		?>
		<table>
		
			<tr>
		
		<?php
		
		
		$i = 0;
		
		
		foreach($keys1[0] as $key){
				
			echo "<th>";
			if($i > 0){
			echo $key;
				if($key == "attivo")
					$iattivo = $i;
			}
			echo "</th>";
			$i = $i + 1;
		}
		
		echo "</tr>";
		
	
		
		foreach ($cursor as $entry) { 			
			
			echo "<tr>";
			
				echo "<td>";
				
				echo "<a href=\"mostra_sensore.php?id_sensore=" ; echo (string)$entry->id_sensore; echo "\">";
					echo " <img src=\"DHT11_low.png\" alt=\"dht11.png\" > ";
				echo "</a>";
					
				echo "</td>";
			
			$i = 0;
			
			foreach($entry as $valore){
			
				if( $i>0){
					echo "<td>";
					if( $i == $iattivo){
						if($valore == true){
								echo "  <svg height=\"40\" width=\"40\">
								  <circle cx=\"20\" cy=\"20\" r=\"15\"  fill=\"green\" />
								</svg> " ;
						}else{
								echo "  <svg height=\"40\" width=\"40\">
								  <circle cx=\"20\" cy=\"20\" r=\"15\"  fill=\"#e60000\" />
								</svg> " ;
						}
					}else{
						
					echo $valore;
					}
					echo "</td>";
				}
			$i = $i + 1;
			}

		echo "</tr>";

		}
		
		?>
		</table>

		</ul>
	</body>
</html>