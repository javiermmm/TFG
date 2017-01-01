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
		
		
//Pasamos la variable desde PHP a JavaScript, para poder invocar el ws
	echo '<script languaje="JavaScript">
            	var rol="'.$rol.'";
            	var myCode="'.$_SESSION["permisoMiCodigo"] .'";
            	var allCode="'.$_SESSION["permisoTodoCodigo"] .'";
            	var user="'. $user .'";
            	var url_submission="'.URL_submisssion.'";
			</script>';
			
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	
		
 ?>


	<div id="main-menu">
		<ul>
			<li><b>Últimos Envíos</b></li>
<!--			
			<li><a href="#">Rankings</a></li>
			<li><a href="#">Globales</a></li>
-->
		</ul>

		<?php require_once('inc/login.inc.php'); ?>
	</div>

	<div id="content">
		<div class="container">
			<h2>Últimos Envíos</h2>
			<table id="tabla">
				<thead>
					<tr>
						<th> Num </th>
						<th> Usuario</th>
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
				window.onload = creaTabla();
			</script>
		</div>
	</div>


<?php require_once('inc/pie.inc.php'); ?>
