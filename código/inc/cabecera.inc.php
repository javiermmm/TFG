
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta charset="UTF-8" />
	
	<title>Acepta el reto</title>
	
	<!-- ESTILOS CSS -->
	<link rel="stylesheet" type="text/css" href="./css/layout.css" />
	<link rel="stylesheet" type="text/css" href="./css/color.css" />
	<link rel="stylesheet" type="text/css" href="./css/estiloTabla.css"/>
	<link rel="shortcut icon" href="./favicon.ico">
	<link rel="shortcut icon" href="./favicon.ico"> 
	<link rel="stylesheet" type="text/css" href="./css/style3.css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
	<link rel="stylesheet" href="/resources/demos/style.css" />
	<link rel="stylesheet" type="text/css" href="./css/vanadium.css" media="screen, tv, projection" />
	<link rel="stylesheet" type="text/css" href="./css/estiloBarraProgreso.css" />
	<link rel="stylesheet" type="text/css" href="./css/problema.css">
	
	
	<!-- SCRIPTS JS-->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <!--	<script src="http://code.jquery.com/jquery-1.8.3.js"></script> -->
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<!--	<script type="text/javascript" src="/scripts/jquery-1.6.1.js"></script> -->
    <script type="text/javascript" src="./js/vanadium_es.js"></script>
	<script>
		var hora = <?php echo  $_SERVER['REQUEST_TIME']; ?>;
		function ref_hora(){
			hora+=1;
			document.getElementById("hora").innerHTML = 
				parseInt(hora/3600%24).toString() + ":" +
				parseInt(hora/600%6) + parseInt(hora/60%10).toString() + ":" +
				parseInt(hora/10%6).toString() + parseInt(hora%10).toString() + " (GMT)";
		}
		setInterval("ref_hora();",1000);
	</script>
  
	<!-- codeMirror (para quicksubmit) -->
   <script src="./js/codemirror/lib/codemirror.js" type="text/javascript"></script>
   <script src="./js/codemirror/mode/clike/clike.js" type="text/javascript"></script>
   <script src="./js/codemirror/keymap/emacs.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="./js/codemirror/lib/codemirror.css"/>	

	<!-- funciones  AJAX -->   
   <script src="./js/funciones.js" type="text/javascript"></script>
   
</head>

<body>
	<?php require_once ('comun.php'); ?>
	<div id="perm-links">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="volumenes.php">Problemas</a></li>
			<li><a href="ultimosEnvios.php">Estadísticas</a></li>
			<li><a href="documentacion.php">Documentación</a></li>
		</ul>
	</div>

	<h1 id="top"><a href="index.php">¡Acepta el reto!</a></h1>
