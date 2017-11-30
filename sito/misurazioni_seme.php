<html>

questa pagina dovrebbe mostrare il grafico della umidità e temperatura e la possibilità di scaricare tutte le misurazioni in un formato particolare
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

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
		
		
		$misurazioni = $client->db_misurazioni->misurazioni;

		$cursor = iterator_to_array( $misurazioni->find( [ 'id_sensore' => 1 ] )); 
	
		$keys1 = iterator_to_array($cursor[0]); #se il db è vuoto cursor è null, bisogna gestire eccezione
		
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
					echo " <img src=\"seme_low.png\" alt=\"dht11.png\" > ";
				echo "</a>";
					
				echo "</td>";
			
			$i = 0;
			
			foreach($entry as $valore){
			
				if( $i>0){
					echo "<td>";
					if($i == 4){

						$valore = (string)$valore;
						// Or using ini_get()
				echo ini_get('include_path');
					}

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