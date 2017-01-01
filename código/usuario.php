<?php 
require_once('./Urls.php'); 
require_once('./inc/cabecera.inc.php'); 

//recogemos el número de volumen que queremos mostrar
	if (isset($_GET['id'])) {
		$idUsuario = $_GET['id'];
		$intervalo = 1200000;
		if (isset ($_SESSION["id"]))
			if ($idUsuario == $_SESSION["id"])
				$intervalo = 3000;
		
		$url=URL_user . $idUsuario;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if (isset ($_SESSION['token']))
			curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json"));

		$result = curl_exec($ch);
		$jsonphp = json_decode($result,true,2048); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		// echo "<pre>";
		// var_dump($jsonphp);
		// echo "</pre>";
		
		if ($httpCode == 200){
			//header ("Location: index.php?notificacion=errorUser");
			//echo $jsonphp["nick"];
		}
		
		if ($httpCode != 200){
			session_destroy();
			header ("Location: index.php?notificacion=errorAuth");
			//echo"roto";
		}
	}



	//recogemos el número de volumen que queremos mostrar
	if (isset($_GET['id'])) {
		$idUsuario = $_GET['id'];
		if (isset($_SESSION["id"])){
			if ($idUsuario == $_SESSION["id"])
				$intervalo = 60000;
		}
		else
				$intervalo = 1200000;
	}
	
		
	//Pasamos la variable desde PHP a JavaScript, para poder invocar el ws
	echo '<script languaje="JavaScript">
				var url_user="'.URL_user.'";
				var url_problem="'.URL_problem.'";
            	var idUsuario="'.$idUsuario.'";
            	var intervalo="'.$intervalo.'";
			</script>';
	
	
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");
?>

<?php 
	// echo $_SERVER['REQUEST_URI'];
	// echo "   ";
	// echo "usuario.php?id=" . $idUsuario;
	
	
?>
	<div id="main-menu">
		<?php require_once('./inc/login.inc.php'); ?>
	</div>
	
	
<div id="content">
	<div id="container">
		<h2>Perfil</h2>
				<table id="tabla">
					<thead>
						<tr>
							<th colspan="2"> Datos Usuario</th>
						</tr>
						<?php 
					//	var_dump ($jsonphp);
							if (isset($jsonphp["name"] )) { ?>
						<tr class="cuerpo filaImpar" id="name" >
							<td>Nombre:  </td>
							<td><?php echo $jsonphp["name"] ?></td>
						</tr>
						<?php } ?>						
						<?php 
							if (isset($jsonphp["nick"] )) { ?>
						<tr class="cuerpo filaPar" id="nick" >
							<td>Nick:  </td>
							<td><?php echo $jsonphp["nick"] ?></td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["email"] )) { ?>
						<tr class="cuerpo filaImpar" id="email" >
							<td>E-mail:  </td>
							<td><?php echo $jsonphp["email"] ?></td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["gender"] )) { ?>
						<tr class="cuerpo filaPar" id="genero">
							<td class="cuerpo filaPar">Género:</td>
							<?php 
								if ($jsonphp["gender"] == "MALE")
									echo '<td class="cuerpo filaPar">Hombre</td>';
								else
									echo '<td class="cuerpo filaPar">Mujer</td>';
							?>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["country"]["nombre"]  )) { ?>
						<tr class="cuerpo filaImpar" id="pais">
							<td >País:  </td>
							<td ><?php echo $jsonphp["country"]["nombre"] ?></td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["institution"]["name"] )) { ?>
						<tr class="cuerpo filaPar" id=institucion>
							<td >Institución:  </td>
							<td ><?php echo $jsonphp["institution"]["name"] ?></td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["role"] )) { ?>
						<tr class="cuerpo filaImpar" id="rol">
							<td >Rol:  </td>
							<td ><?php echo $jsonphp["role"];?>
							</td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["mailNotification"] )) { ?>
						<tr class="cuerpo filaPar" id="mailNotification">
							<td >Notificaciones:  </td>
							<td>
							<?php echo $jsonphp["mailNotification"];?>
							</td>
						</tr>
						<?php } ?>
						<?php 
							if (isset($jsonphp["registrationDate"] )) { 
								list ($fecha, $resto) = explode('T', $jsonphp["registrationDate"] );
							?>
						<tr class="cuerpo filaImpar" id="date">
							<td >Fecha de registro:  </td>
							<td>
							<?php echo  "registrado el " . $fecha . " a las " . $resto;?>
							</td>
						</tr>
						<?php } ?>
					</thead>
					<tbody id='cont'>					
					</tbody>
				</table>
				<?php 
					if (   (isset($_SESSION["id"])) && ($idUsuario == $_SESSION["id"])    ||    ((isset($_SESSION["rol"]))  &&  ($_SESSION["rol"] == "ADMIN"))  ) {
				?>
	
				<?php } ?>
		<h2 id="title_ac">Problemas Aceptados</h2>		
				<table id="tabla">
					<thead>
						<tr>
							<th> Número</th>
							<th> Título</th>
						</tr>
					</thead>
					<tbody id='cont2'>					
					</tbody>
				</table>
				
				<script>
					window.onload = tablaAcer();
					window.onload = refrescaAcertados();
				</script>

		</div>
</div>





<?php require_once('./inc/pie.inc.php'); ?>
