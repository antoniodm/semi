<html>

//gli attivi potrebbero avere uno sfondo diverso
//cliccando l' id del sensore porta alla pagina del sensore da cui si può:
	-cambiare il nome della pianta
	-cambiare lo stato attivo/non attivo
	-eliminarlo

	
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
	
	border: 1px solid black;
	border-collapse: collapse;
	
	
}


td{
	border: 1px solid black;
	
	padding: 40px;
	
	
}


th{
		border: 1px solid black;

	
	
}
</style>

	<body>
		<ul>
		<?php


		require 'vendor/autoload.php';

		$client = new MongoDB\Client("mongodb://localhost:27017");		
		
		
		$sensori = $client->db_sensori->sensori;

		$cursor = iterator_to_array( $sensorCollection->find( [ 'attivo' => true ] )); #se il db è vuoto o non ci sono sensori attivi bisogna gestire l' eccezzione
	
		$keys1 = iterator_to_array($cursor[0]);
		
		$keys1[] = array_keys($keys1);
	
		echo "<table>";
		echo "<tr>";
		
		$i = 0;
		
		
		foreach($keys1[0] as $key){
				
			echo "<th>";
			if($i > 0){
			echo $key;		
			}
			echo "</th>";
			$i = $i + 1;
		}
		
		echo "</tr>";
		
	
		
		foreach ($cursor as $entry) { 			
			
			echo "<tr>";
			
				echo "<td>";
				
				echo "<a href=\"edit_sensore.html\">";
					echo " <img src=\"DHT11_low.png\" alt=\"dht11.png\" > ";
				echo "</a>";
					
				echo "</td>";
			
			$i = 0;
			
			foreach($entry as $valore){
			
				if( $i>0){
					echo "<td>";
									
					echo $valore;
					
					echo "</td>";
				}
			$i = $i + 1;
			}

		echo "</tr>";

		}
		
		
		echo "</table>";

		?>
		</ul>
	</body>
</html>