<?php
		require_once('inc/cabecera.inc.php'); 
		require_once('./Urls.php'); 

	if(isset($_POST['email'])){
		$fields = array(
			'email' => htmlspecialchars($_POST['email']),
		);

		//string json para el envio
		$fields_string="{";
		foreach($fields as $key=>$value) { 
			$fields_string .= '"'.$key.'":"'.$value.'",'; //concatenamos valores array
		}

		$fields_string = substr($fields_string, 0, -1); //eliminamos la ultima coma
		trim($fields_string, ',');
		$fields_string.="}";

		$fields_string=json_encode($fields);
		
		//conexion curl para el envio
		$ch = curl_init();

		//$url="http://acr.programame.com/ws/user/add?url=http://acr/activate?id={userid}&key={key}";
		$url=URL_user . "forgot-password";

		//set the url, number of POST vars, POST data 
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		
		if ($httpCode == 200){
			header ("Location: index.php?notificacion=mail");
			//echo "1";
		}
		else{ //ha habido un error
			header ("Location: index.php?notificacion=errorLogin");
			//echo "2";
		}
	}

 ?>

	<div id="main-menu">
		<?php require_once('inc/login.inc.php'); ?>
	</div>

	<div id="content">
		<div id="container">
			<h2>Recuerda tu contraseña</h2>
				<form method='post' action='recuerda.php'> 
					<table id="formularioRegistro">
						<tr>
						  <td class="rtabform" ><label name="email">Email:</label>
						  </td>
						  <td id="celdaMail"class="segunda">
								<input name="email" id="email" type="text" class="form-text :email :required : only_on_blur" onblur="validarMail();"/> 
						  </td>
						  <td>
							<button>Enviar</button>
						  </td>	
						</tr>
					</table>		
				</form>
		</div>
	</div>

<?php require_once('inc/pie.inc.php'); ?>