<?php 
	require_once('./Urls.php');
	require_once('inc/cabecera.inc.php'); 
	
	if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
		setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	
	
	$url=URL_submisssion.$_POST['cod'].'/comment';

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
	
	var_dump ($result["methods"][2]["allowed"]);
	
	if ($result["methods"][2]["allowed"] == true) {
		$url=URL_submisssion.$_POST['cod'].'/comment';

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
		$result = curl_exec($ch);
		$jsonphp = json_decode($result,true,2048); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		header ("Location: codigo_enviado.php?cod=" . $_POST['cod'] . "&title=" . $_POST['title'] . "&num=" . $_POST['num'] . "&lang=" . $_POST['lang'] );
	}
	else {
		header ("Location: index.php?notificacion=errorPermiso");
	}
	
	
	require_once('inc/pie.inc.php');	
?>