<?php

	//RECAPTCHA
	require_once('recaptchalib.php');
	require_once('Urls.php');

	extract($_POST);
	
	$privatekey = "6LfA0dgSAAAAABbPDWtxRJDFfDzKdgM00P4vOQHE";
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) { 
		header ("Location: registro.php");  
	}
	else{

		$an= $anhoNac;
		$mo= $mesNac;
		$da= $diaNac;
		$fecha= $an."-".$mo."-".$da."T00:00:00+02:00";

		// COMPROBAR QUE EXISTEN LAS VARIABLES ANTES DE COGERLAS isset($_POST["campo"]);
		//creamos el array con las variables recogidas del formulario

		$fields = array(
			'name' => htmlspecialchars($name),
			'nick' => htmlspecialchars($nick),
			'gender' => $gender,
			'email' => htmlspecialchars($email),
			'institutionId' => isset($institucion)? $institucion : null,
			'countryCode' => $country,
			'role' => "STUDENT",
			'password' => $password,
			'mailNotification' => !isset($mailNotification)? "NEVER" : $mailNotification,
			'birthday' => $fecha
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
		$url=URL_user_activation;

		//set the url, number of POST vars, POST data 
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		
		if (($httpCode == 200) || ($httpCode == 0)){
			header ("Location: index.php?notificacion=mail");
		}
		else{ //ha habido un error
			header ("Location: index.php?notificacion=errorLogin");
		}
	}
?>
