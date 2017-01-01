<?php 
require_once('inc/cabecera.inc.php');
require_once('./Urls.php');  
echo '<script languaje="JavaScript">
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
			<h2>Volúmenes</h2>
			<!--  <div id="images"> -->
			<table id="tabla">
				<thead>
					<tr>
						<th> ID </th>
						<th> AC/Envíos </th>
					</tr>
				</thead>
				<tbody id='cont'>
				</tbody>
			</table>
			
			<script>
				window.onload = tablaVol();
				window.onload = refrescaTabla();
			</script>
		</div>
		<div style="margin: 10px; font-size: 90%; text-align: justify;">
				  <em>¿Qué significan estos números?</em> Los números <tt>A/T</tt> de cada volumen indican el número de envíos <em>aceptados</em> y el número de envíos <em>totales</em> entre todos los problemas de ese volumen. Son interesantes para hacerse una idea de la dificultad de un volumen en conjunto: cuanto más alto sea el porcentaje de envíos aceptados más fácil serán, normalmente, los problemas de ese volumen.
		</div>
	</div>

<?php require_once('inc/pie.inc.php'); ?>
