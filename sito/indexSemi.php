<html>

//gli attivi potrebbero avere uno sfondo diverso
//cliccando l' id del sensore porta alla pagina del sensore da cui si può:
	-cambiare il nome della pianta
	-cambiare lo stato attivo/non attivo
	-eliminarlo

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

	<body>
		<ul>
		<?php


		require 'vendor/autoload.php';

		$client = new MongoDB\Client("mongodb://localhost:27017");		
		
		
		$sensori = $client->db_sensori->sensori;

		$cursor = iterator_to_array( $sensori->find( [ 'attivo' => true ] )); 
	
		$keys1 = iterator_to_array($cursor[0]); #se il db è vuoto cursor è null, bisogna gestire eccezzione
		
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
				
				echo "<a href=\"mostra_seme.php?id_sensore="; echo (string)$entry->id_sensore; echo "\">";
					echo " <img src=\"seme_low.png\" alt=\"dht11.png\" > ";
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