<?php require_once('inc/cabecera.inc.php'); ?>

	<div id="main-menu">
		<?php require_once('inc/login.inc.php'); ?>
	</div>

	<div id="content">
		<div id="container">
			<h2>!Bienvenido a Programame!</h2>
				<?php 
					if (isset($_GET["notificacion"])){
						$noti=$_GET["notificacion"];
						if ($noti=="errorLogin"){
							echo "<h2>Error de login</h2>
								  <h3>Ooops! Esto es embarazoso... Tu usuario o contraseña no son correctos</h3>";
						}
						else if ($noti=="Activacion"){
							echo "<h2>Activacion se ha realiza con exito</h2>
								  <h3>Logueate</h3>";
						}
						else if ($noti=="mail"){
							echo "<h2>Mail en Camino</h2>
								  <h3>Para terminar el registro revisa tu mail.</h3>";
						}
						else if ($noti=="errorEnvio"){
							echo "<h2>Hubo un error al enviar el problema</h2>
								  <h3>Ooops! Esto es embarazoso... El envio no se ha podido realizar correctamente. Por favor intentalo de nuevo :-)</h3>";
						}
						else if ($noti=="exitoEnvio"){
							echo "<h2>Problema enviado</h2>
								  <h3>El envio del problema se realizó con éxito. Sólo queda esperar para ver tu resultado</h3>";
						}
						else if ($noti=="errorBuscar"){
							echo "<h2>Problema inexistente</h2>
								  <h3>Ooops! Esto es embarazoso... El problema que buscas no existe</h3>";
						}
						else if ($noti=="errorUser"){
							echo "<h2>Datos inexistentes</h2>
								  <h3>Ooops! Esto es embarazoso... No se han encontrado los datos del usuario</h3>";
						}
						else if ($noti=="errorUPermiso"){
							echo "<h2>Error en la operacion</h2>
								  <h3>No tienes permiso para realizar esa operación</h3>";
						}
						else if ($noti=="errorAuth"){
							echo "<h2>Esto... ¿Y tu quién eras?</h2>
								  <h3>Es posible que tu sesión haya caducado o haya habido algun problema al identificarte. Prueba a loguearte de nuevo.</h3>";
						}
						else if ($noti=="errorProblem"){
							echo "<h2>No te vas a creer lo que ha pasado...</h2>
								  <h3>Parece que hemos tenido un problemilla con el enunciado del problema, y no podemos mostrarlo ahora mismo. Vuleve a intentarlo más tarde.</h3>";
						}
					}
					else
						echo ("Aqui va la presentacion");
						
					
				?>
		</div>
	</div>

<?php require_once('inc/pie.inc.php'); ?>
