<?php 
	require_once('inc/cabecera.inc.php'); 
	require_once('./Urls.php'); 
	// Include the GeSHi library
	include('geshi.php');
	
	if (!isset($_SESSION['permisoMiCodigo']))
		$_SESSION["permisoMiCodigo"] = false;
		
	if (!isset($_SESSION['permisoTodoCodigo']))
		$_SESSION["permisoTodoCodigo"] = false;
		
	if (!isset($_SESSION['nick']))
		$user = NULL;
	else 
		$user = $_SESSION["nick"];

	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	
?>

		<div id="main-menu">
			<?php require_once('inc/login.inc.php'); ?>
		</div>

		<div id="content">
			<div id="container">
				<?php 
					if (($_SESSION['permisoTodoCodigo']) || (($_SESSION['permisoMiCodigo'])  &&  ($user != NULL))) {
							
						if (isset($_GET['cod'])){
							
							$url=URL_submisssion.$_GET['cod'];

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
							curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 

							$resultParam = curl_exec($ch);
							$jsonphpParam = json_decode($resultParam,true,2048); 
							$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							if ($httpCode != 200) {
							  echo "<h2 id='titulo'>Solicitud incorrecta</h2>";
							  // Lo suyo sería poner un else... no acabamos la página; nos falta
							  // cerrar divs y el pie.inc.php... pero dado que es algún listillo
							  // haciendo cosas feas, peor para él.
							  exit;
							}

							$lenguaje= $jsonphpParam['language'];
							$result= $jsonphpParam['result'];
							if ($jsonphpParam['language'] == "CPP")
								$lenguaje="C++";
							$fecha = $jsonphpParam['submissionDate'];
							/*
							echo "<h2 id='titulo'><a href='enunciado.php?num=" . $jsonphpParam['problem']['num'] . "'>" . htmlspecialchars($jsonphpParam['problem']['title']) . "  ---  ID " 
							. htmlspecialchars($jsonphpParam['problem']['num']) . " --- Lenguaje: " . $lenguaje . " --- Resultado: " . $result . "</a></h2>";
							*/
							echo "<h2 id='titulo'>Informaci&oacute;n del env&iacute;o ". htmlspecialchars($_GET['cod']) . "</h2>";
							echo "<table id='tabla' style='margin-left:0px;'>";
							echo "<tr><th>Id problema</th><td><a href='enunciado.php?num=" . $jsonphpParam['problem']['num'] . "'>" . htmlspecialchars($jsonphpParam['problem']['num'])."</td></tr>";
							echo "<tr><th>T&iacute;tulo</th><td><a href='enunciado.php?num=" . $jsonphpParam['problem']['num'] . "'>" . htmlspecialchars($jsonphpParam['problem']['title'])."</td></tr>";
							echo "<tr><th>Lenguaje del env&iacute;o</th><td>$lenguaje</td></tr>";
							echo "<tr><th>Veredicto</th><td>$result</td></tr>";
							echo "<tr><th>Fecha</th><td>$fecha</td></tr>";
							echo "</table>";
							$ckfile = tempnam ("/", "acrsession");
							
							$url=URL_submisssion.$_GET['cod'].'/code';

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
							curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
							

							echo '<h3>Código fuente</h3>';
							$result = curl_exec($ch);
							$jsonphp = json_decode($result,true,2048); 
							$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							htmlspecialchars($result);
							if ($httpCode == 200){
								// Make a new GeSHi object, with the source, language and path set
								$language = "JAVA";
								if (isset($_GET['lang'])){
									if ($_GET['lang'] == "CPP")
										$_GET['lang'] = "C++";
									$language = $_GET['lang'];
								}
								$path = 'geshi/';

								$geshi = new GeSHi($result, $language, $path);

								// and simply dump the code!
								echo $geshi->parse_code();
							}
							echo '<p  style="text-align: right"><a href="enviar.php?num=' . $numProblema . $jsonphpParam['problem']['num'] . '">Enviar otro</a></p>';
						        
							//ESTO ES PARA PEDIR EL COMENTARIO
							$url=URL_submisssion.$_GET['cod'].'/comment';

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
							curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
							
							$result = curl_exec($ch);
							$jsonphp = json_decode($result,true,2048); 
							$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							$result= htmlspecialchars($result);
							if ($httpCode == 200){
								echo "<h3>Comentario asociado a este envío</h3>";
								echo "<form method='post'>";
								echo "<input name='cod' type='hidden' value='". $_GET['cod'] . "'>";
								echo "<input name='title' type='hidden' value='". $jsonphpParam['problem']['title'] . "'>";
								echo "<input name='num' type='hidden' value='". $jsonphpParam['problem']['num'] . "'>";
								echo "<input name='lang' type='hidden' value='". $jsonphpParam['language'] . "'>";
								echo '<p>Aquí puedes ver el comentario que asociaste a este envío, borrarlo, editarlo, o añadir uno nuevo si no lo has hecho ya: </p>
										<textarea rows="6" cols="40" id="comentario" name="comentario" class="comentario" onkeyup="contar(this);">' . $result . '</textarea>
										<span id="letras">500/500 caracteres</span>
										<script>
											function contar(input) {
												//Comprobamos que no pase de 5000 caracteres y si pasa, que borre los sobrantes
												if (input.value.length >= 500) {
												input.value = input.value.substring(0,500);
												}
												//almacenamos el resto
												var resto = 500 - input.value.length;
												 
												//imprimimos los caracteres restantes en el span
												var final=document.getElementById("letras");
												final.innerHTML=resto+"/500 caracteres";
											}
										</script>';
								echo "<br>";
								echo "<button id='edit_comment' onclick =\"this.form.action = 'edit_comment.php'\"> Editar </button>";
								echo "<button id='delete_comment' onclick = \"this.form.action = 'delete_comment.php'\"> Borrar </button>";
								echo "</form>";			
							}
						}
					}
					else
						echo "<h2 id='titulo'>Información restringida</h2>";
				?>
			</div>
		</div>


<?php require_once('inc/pie.inc.php'); ?>
