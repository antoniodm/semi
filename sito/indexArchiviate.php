<html>

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


		<?php


		require 'vendor/autoload.php';

		$client = new MongoDB\Client("mongodb://localhost:27017");		
		
		$db_archiviate = $client->db_archiviate;
		
		$lista_archiviate = iterator_to_array($db_archiviate->listCollections());
		
		
		?>



	<body>
			
		<ul>
		
			<table>
			
				<tr>
					<th>
						 
					</th>
				
					<th>
						Pianta
					</th>

				</tr>
			
			<?php
				
				foreach($lista_archiviate as $archiviata){
					echo "<tr>";
						echo "<td>";
						
							echo "<a href=\"mostra_archiviata.php?pianta="; echo (string)$archiviata->getName(); echo "\">";
							echo " <img src=\"seme_low.png\" alt=\"dht11.png\" > ";
							echo "</a>";
								
						
						echo "</td>";
							
							
						echo "<td>";
						
							echo $archiviata->getName();

						echo "</td>";

					echo "</tr>";
				}
			
			
			?>

			<table>
		
		<ul>
	
	</body>
</html>