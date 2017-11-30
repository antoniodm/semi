<?php
	require_once ('jpgraph/src/jpgraph.php');
	require_once ('jpgraph/src/jpgraph_line.php');


	require 'vendor/autoload.php';
	
	$ipdatabase = "mongodb://localhost:27017";
	
	$client = new MongoDB\Client($ipdatabase);
	
	$id_sensore = $_GET['id_sensore'];
	
	$id_sensore;
	
	$pianta = "indefinito";
	
	$sensori = $client->db_sensori->sensori;
	
	$misurazioni = $client ->db_misurazioni->misurazioni;
	
	$sensore = $sensori->findOne( ['pianta' => $pianta ] );
	
	
	
	
	if( $sensore == null){
		echo "non esiste più la pianta"; //cercare le misurazioni in un altro db;
	}else{
		
		
		$cursore_misurazioni = $misurazioni->find( [ 'id_sensore' => $sensore->id_sensore ]);
		
		if( $cursore_misurazioni == null ){
			
			echo "non trovato" ; //gestire
		}else{
			
			$ydata = array();
			$xdata = array();
			$idata = array();
			
			
			
			$i = 0;
			
			foreach ( $cursore_misurazioni as $misurazione ){
				
				if(($i % 500) == 0 ){
					$idata[] = $i;
				}
				$i = $i + 1;
				$ydata[] = $misurazione->umidita;
				$xdata[] = $misurazione->temperatura;
				
			}
			
			$graph = new Graph(640,480);
			$graph->SetScale('textlin');

			$theme_class=new UniversalTheme;
			
			$graph->SetTheme($theme_class);
			$graph->img->SetAntiAliasing(false);
			$graph->title->Set($pianta);
			$graph->SetBox(false);
			
			$graph->img->SetAntiAliasing();
			
			$graph->xgrid->Show();
			//$graph->xgrid->SetLineStyle("solid");
			//$graph->xaxis->SetTickLabels($idata);
			$graph->xgrid->SetColor('#E3E3E3');
			
			// Create the first line
			$p1 = new LinePlot($ydata);
			$graph->Add($p1);
			$p1->SetColor("#6495ED");
			$p1->SetLegend('Umidità');

			// Create the second line
			$p2 = new LinePlot($xdata);
			$graph->Add($p2);
			$p2->SetColor("#B22222");
			$p2->SetLegend('Temperatura');

			
			$graph->legend->SetFrameWeight(1);
			
			// Display the graph
			$graph->Stroke();

			//$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
			
			//$fileName = "/tmp/imagefile.png";
			//$graph->img->Stream($fileName);
			
		}
		
		
		
	}
?>