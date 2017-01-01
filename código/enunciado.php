<?php
	require_once('./Urls.php'); 
	require_once('inc/cabecera.inc.php');
	
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");
	
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
			//echo ("MALO");
			header ("Location: index.php?notificacion=errorBuscar");
			//var_dump($httpCode);
		}
	}

	
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
	
	//CURL PARA CONSEGUIR EL CODIGO HTML
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL, $URLenunciado);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$result = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if ($httpCode != 200)
		header ("Location: index.php?notificacion=errorProblem");
	
	
	echo '<script languaje="JavaScript">
		var url_problem="'.URL_problem.'";
	</script>';
?>

<div id="main-menu">
	<ul>
		<li><b>Enunciado</b></li>
		<li><a href="<?php echo $URLpdf ?>"  target="_blank">PDF</a></li>
		<?php
			echo '<li><a href="enviar.php?num=' . $numProblema . '">Enviar</a></li>';
			// Este enlace también se construye en el contenido de codigo_enviado.
		?>
		<?php
			echo '<li><a href="estadisticasProblema.php?num=' . $numProblema . '">Estadisticas</a></li>';
		?>
		<?php
			echo '<li><a href="creditos.php?num=' . $numProblema . '">Créditos del problema</a></li>';
		?>
	</ul>
	<?php require_once('inc/login.inc.php'); ?>
</div>

<div id="content">
	<div id="container">
		<h1><?php echo  htmlspecialchars($Titulo); ?></h1>
			<?php
				echo $result;
			?>
	</div>
</div>


<?php require_once('inc/pie.inc.php'); ?>
