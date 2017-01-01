<?php 
	require_once('inc/cabecera.inc.php');
	require_once('./Urls.php'); 
	
	if (isset ($_GET['num'])) {
		$numProblema = $_GET['num'];
		$url=URL_problem.$numProblema;

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$result = curl_exec($ch);
		$jsonphp = json_decode($result,true,2048); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$Titulo= $jsonphp['title'];
		
		if ($httpCode != 200){
			header ("Location: index.php?notificacion=errorBuscar");
		}
	}
		
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");

	//CURL PARA CONSEGUIR LA URL
	$url=URL_problem.$numProblema."/paths";

	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$result = curl_exec($ch);
	$jsonphp = json_decode($result,true,2048); 
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	$URLenunciado= $jsonphp['htmlEmLink'];
	$URLpdf= $jsonphp['pdfLink'];
	if ($httpCode != 200){
		//echo ("MALO");
		//header ("Location: index.php?notificacion=errorBuscar");
		//var_dump($httpCode);
	}	
		
	if (!isset($_SESSION['id']))
		$user = NULL;
	else 
		$user = $_SESSION["id"];
		
	echo '<script languaje="JavaScript">
            	var numProblema = "'.$numProblema.'";
            	var usuario = "'.$user.'";
				var tituloProblema = "'.$Titulo.'";
				var url_problem = "'.URL_problem.'";
				var url_user = "'.URL_user.'";
			</script>';
			
	$jsonProblemaString = file_get_contents(URL_problem.$numProblema.'/');
	$jsonProblema = json_decode ($jsonProblemaString, true);
 ?>

	
		<div id="main-menu">
			<ul>
				<?php
					echo '<li><a href="enunciado.php?num=' . $numProblema . '">Enunciado</a></li>';
				?>
				<li><a href="<?php echo $URLpdf ?>"   target="_blank">PDF</a></li>
				<?php
					echo '<li><a href="enviar.php?num=' . $numProblema . '">Enviar</a></li>';
				?>
				<li><b>Estadisticas</b></li>
				<?php
					echo '<li><a href="creditos.php?num=' . $numProblema . '">Créditos del problema</a></li>';
				?>
			</ul>
			<?php require_once('inc/login.inc.php'); ?>
		</div>

		<div id="content">
			<div id="container">
				<h1><?php echo  htmlspecialchars($Titulo); ?></h1>
				
				<!--Div that will hold the pie chart-->
				<div id="chart_div"></div>
				<div id="chart_div2"></div>
				
				<div id="title_best">
					<?php 
						if ((isset($_SESSION['id'])) ) {
					?>	
						<div id="mejor_problema">
						</div>
					<?php }?>
					
					<h2 id="title_envios">Clasificación</h2>
					<div id="accepted">
					</div>
				</div>
				
				<!--Load the AJAX API-->
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript">

					// Load the Visualization API and the piechart package.
					google.load('visualization', '1.0', {'packages':['corechart']});

					// Set a callback to run when the Google Visualization API is loaded.
					google.setOnLoadCallback(drawChart);

					// Callback that creates and populates a data table,
					// instantiates the pie chart, passes in the data and
					// draws it.
					function drawChart() {
						
						var data1 = google.visualization.arrayToDataTable
							([ 
								<?php echo "['Task', 'Languages'],
												['C',".$jsonProblema['c']."],
												['C++',".$jsonProblema['cpp']."],
												['JAVA',".$jsonProblema['java']."]"; 
								?>
							]);

						var options1 = {
						  is3D: 'true',
						  title: 'Lenguajes'
						};
						
						// Create the data table.
						var data2 = new google.visualization.DataTable();
						data2.addColumn('string', 'Lenguajes');
						data2.addColumn('number', 'Accepted');
						data2.addColumn('number', 'Wrong Answer');
						data2.addColumn('number', 'Presentation Error');
						data2.addColumn('number', 'Time Limit');
						data2.addColumn('number', 'Memory Limit');
						data2.addColumn('number', 'Output Limit');
						data2.addColumn('number', 'Restricted Function');
						data2.addColumn('number', 'Run Time Execution exception');
						data2.addColumn('number', 'Compilation Error');
						data2.addColumn('number', 'Internal eRror');
						
						data2.addRow(['AC', <?php echo $jsonProblema['ac'];?>, null,null,null,null,null,null,null,null,null]);
						data2.addRow(['WA', null, <?php echo $jsonProblema['wa'];?>,null,null,null,null,null,null,null,null]);
						data2.addRow(['PE', null,null, <?php echo $jsonProblema['pe'];?>,null,null,null,null,null,null,null]);
						data2.addRow(['TL', null,null,null, <?php echo $jsonProblema['tl'];?>,null,null,null,null,null,null]);
						data2.addRow(['ML', null,null,null,null, <?php echo $jsonProblema['ml'];?>,null,null,null,null,null]);
						data2.addRow(['OL', null,null,null,null,null, <?php echo $jsonProblema['ol'];?>,null,null,null,null]);
						data2.addRow(['RF', null,null,null,null,null,null, <?php echo $jsonProblema['rf'];?>,null,null,null]);
						data2.addRow(['RTE',null,null,null,null,null,null,null, <?php echo $jsonProblema['rte'];?>,null,null]);
						data2.addRow(['CE', null,null,null,null,null,null,null,null, <?php echo $jsonProblema['ce'];?>,null]);
						data2.addRow(['IR', null,null,null,null,null,null,null,null,null, <?php echo $jsonProblema['ir'];?>]);

						// Set chart options
						 var options2 = {
							title: 'Resultados',
							vAxis:{viewWindow: {min: 0}},
							colors: ['green','red', 'yellow','blue','orange','purple','#A9D0F5','black','grey','#2EFE9A'],
							legend: 'none', 
							isStacked: true
						};

						// Instantiate and draw our chart, passing in some options.
						var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
						var chart2 = new google.visualization.BarChart(document.getElementById('chart_div2'));
						chart.draw(data1, options1);
						chart2.draw(data2, options2);
					}
				</script>
				
				<script>
					window.onload = tablaAC();
					window.onload = show_best();
					window.onload = refrescaTablaAC();
				</script>
			</div>
		</div>


<?php require_once('inc/pie.inc.php'); ?>
