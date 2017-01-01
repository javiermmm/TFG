<?php
	require_once('inc/cabecera.inc.php'); 
	require_once('./Urls.php'); 
	
	//recogemos el número de volumen que queremos mostrar
	if (isset($_GET['vol']))
		$numVolumen = $_GET['vol'];
		
	//Pasamos la variable desde PHP a JavaScript, para poder invocar el ws
	echo '<script languaje="JavaScript">
            	var numVolumen="'.$numVolumen.'";
				var url_volumenes="'.URL_volumenes.'";
			</script>';
	
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");
?>

	<div id="main-menu">
		<?php require_once('inc/login.inc.php'); ?>
	</div>

	<div id="content">
		<div class="container">
			<h2>Problemas</h2>
			<table id="tabla">
				<thead>
					<tr>
						<th> ID </th>
						<th> Título </th>
						<th> AC/Envios </th>
						<th> AC/Usuarios </th>
					</tr>
				</thead>
				<tbody id='cont'>
				</tbody>
			</table>
			
			<script>
				window.onload = tablaProb();
				window.onload = refrescaTablaProb();
			</script>
		</div>
		<div style="margin: 10px; font-size: 90%; text-align: justify;">
<p>
				  <em>¿Qué significan estos números?</em> La columna del centro muestra una pareja de números <tt>A/T</tt> indicando el número de envíos <em>aceptados</em> y el número de envíos <em>totales</em> de cada problema. Son interesantes para hacerse una idea de la dificultad del problema: cuanto más alto sea el porcentaje de envíos aceptados más fácil será, normalmente, un problema.
</p>
<p>
				  La columna derecha indica el número de <em>usuarios</em> que han conseguido resolver el problema, y cuántos lo han intentado. El porcentaje de aceptados en este caso indica la probabilidad de que, al final, resuelvas el problema; o, viéndolo de otro modo, el porcentaje de usuarios que, de momento, han dado el problema por imposible.
</p>
<p>
																																	  El número de aceptados en ambas columnas no tiene por qué ser igual. Si un usuario envía el mismo problema correctamente dos veces, contará por dos en la primera columna, y por uno en la segunda.
</p>
		</div>
	</div>

<?php require_once('inc/pie.inc.php'); ?>
