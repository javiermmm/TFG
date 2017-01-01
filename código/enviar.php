<?php 

	require_once('./inc/cabecera.inc.php'); 
	require_once('./Urls.php'); 

	
	if ((isset($_SESSION["id"])) && (isset ($_GET['num']))){
		$url=URL_user . $_SESSION["id"] . "/submissions/problem/" . $_GET['num'];
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "OPTIONS");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
		curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
		$result = curl_exec($ch);
		$jsonphp = json_decode($result,true,2048); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$result = json_decode($result, true);

		$puedePost = $result["methods"][1]["allowed"];
		$lenguajes = $result["methods"][1]["details"]["languages"];
	}
	
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");
	
	if (isset ($_GET['num'])) {
	
		$numProblema = $_GET['num'];
	
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

?>



<div id="main-menu">
	<ul>
		<?php
			echo '<li><a href="enunciado.php?num=' . $numProblema .  '">Enunciado</a></li>';
		?>
		<li><a href="<?php echo $URLpdf ?>"   target="_blank">PDF</a></li>
		<li><b>Enviar</b></li>
		<?php
			echo '<li><a href="estadisticasProblema.php?num=' . $numProblema .  '">Estadisticas</a></li>';
		?>
		<?php
			echo '<li><a href="creditos.php?num=' . $numProblema . '">Créditos del problema</a></li>';
		?>
	</ul>

<?php require_once('inc/login.inc.php'); ?>
</div>

<div id="content">
	<div id="container">
		<div id="enviar" class="onlyuser">
			<h1> <?php echo htmlspecialchars($Titulo); ?></h1>
				<ul>

		  
					<form id="form_submit" method="post" action="submiter.php" onsubmit="return compruebaVacio()" enctype="multipart/form-data" name="formulario">
						<input  type="hidden" id="idProblema" name="idProblema" value=<?php echo $numProblema ?> />

						<p>Lenguaje:</p> 
						<select id="language" name="language" class="form-text">
							<?php 
								if ($puedePost) {
									for ($i=0; $i < count($lenguajes); $i++) {
										if ($lenguajes[$i] == "CPP") { 
											$lenguajes[$i] = "C++";
											echo "<option value='CPP'>" . $lenguajes[$i] . "</option>";
										} else {
											echo "<option value=" . $lenguajes[$i] . ">" . $lenguajes[$i] . "</option>";
										}
									}
								}
								else
									echo "<option value='prohibido'>No puedes hacer este envío</option>";
							?> 
						 </select>
								 
						<p>Código:</p><textarea rows="15" cols="80" id="quick" name="quick" class="form-text" ></textarea>
						<p>Archivo: </p>
						
							<script>
								var editor = CodeMirror.fromTextArea(document.getElementById('quick'), {
								matchBrackets: true,
								lineNumbers: true,
								mode: "text/x-csrc",
								keyMap: "emacs",
								//onBlur: compruebaVacio
							  });
							 						  
							  function compruebaVacio() {
					
									fichero=document.getElementById("file").value;
									var texto = editor.getValue();
									
										if ((texto == "") && (fichero == "") ) {
											return false; 
										}
										else{
											return true; 
										}
								}
								function limpiar() {
								alert("hola");
									document.formulario.file.value = "";
								}
							</script>		  
							
						<p id="f"><input type="file" id="file" name="file" class="form-text" onclick="alerta()"/><span id="aviso">Este fichero tendrá prioridad sobre el área de texto</span></p>
						<input name='limpiar' onclick='document.formulario.file.value = "";' value='Limpiar' type="button" />
						
						<p>Aquí puedes asociar un comentario al envío:</p><textarea rows="6" cols="40" id="comentario" name="comentario" class="comentario" onkeyup="contar(this);"></textarea>
						<span id="letras">500/500 caracteres</span>

						<!-- <input id="campo" name="campo" type="hidden" /> -->
						<?php $registrado = isset($_COOKIE['acrsession']);
							if ($registrado)
								if ($puedePost)
									echo '<p><input type="submit" id="botenviar" name="botenviar" value="Enviar"/></p>';
								else
									echo '<p style = "color:red;">No tienes permisos para enviar</p>';
							else
								echo '<p style = "color:red;">Inicia sesión antes de enviar</p>';
						?>
					</form>
				</ul>
		</div>
	</div>
</div>


<?php require_once('inc/pie.inc.php'); ?>
