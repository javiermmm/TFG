<?php 
require_once('inc/cabecera.inc.php');
require_once('./Urls.php'); 

	if (!isset($_SESSION["rol"]))
		$rol = "STUDENT";
	else
		$rol = $_SESSION["rol"];

	if (!isset($_SESSION['permisoMiCodigo']))
		$_SESSION["permisoMiCodigo"] = false;
		
	if (!isset($_SESSION['permisoTodoCodigo']))
		$_SESSION["permisoTodoCodigo"] = false;
		
	if (!isset($_SESSION['nick']))
		$user = NULL;
	else 
		$user = $_SESSION["nick"];
		
	if (!isset($_SESSION['id']))
		$id = NULL;
	else
		$id = $_SESSION['id'];
		
//Pasamos la variable desde PHP a JavaScript, para poder invocar el ws
	echo '<script languaje="JavaScript">
            	var rol="'.$rol.'";
            	var myCode="'.$_SESSION["permisoMiCodigo"] .'";
            	var allCode="'.$_SESSION["permisoTodoCodigo"] .'";
            	var user="'. $user .'";
            	var id="'. $id .'";
            	var url_user="'.URL_user.'";
			</script>';
			
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	
		
	if (! isset($_SESSION["token"]))
		header ("Location: index.php");
 ?>

	<div id="main-menu">

		<?php require_once('inc/login.inc.php'); ?>
	</div>

	<div id="content">
		<div class="container">
			<h2>Mis Últimos Envíos</h2>
			<table id="tabla">
				<thead>
					<tr>
						<th> Num </th>
						<th> ID Problema</th>
						<th> Título Problema</th>
						<th> Resultado </th>
						<th> Lenguaje</th>
						<th> Ejecución </th>
						<th> Memoria </th>
						<th> Clasificación </th>						
						<th> Fecha de Envío </th>
					</tr>
				</thead>
				<div id="img"></div>
				<tbody id='cont'>
				</tbody>
			</table>

			<script>
				window.onload = tablaEnviosUsuario();
				var timerID2;
				function refrescaEnviosUsuario(){
					$('.container').append('<img id="gif" src="./images/dancer_024.gif" WIDTH="100" HEIGHT="100">');
					timerID2 = setTimeout(tablaEnviosUsuario, 1000);
				}
				window.onload = refrescaEnviosUsuario(timerID2);
			</script>
		</div>
	</div>

<?php require_once('inc/pie.inc.php'); ?>
