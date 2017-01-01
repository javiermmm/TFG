<?php
require_once("inc/comun.php");
require_once('./Urls.php'); 

if(!isset($_POST["user"]) || !isset($_POST["pass"])||$_POST["pass"]=="" || $_POST["user"]=="")
	header ("Location: index.php");
	
//no se porque funciona así, pero funciona
$data=array('user'=>$_POST["user"],'password'=>$_POST["pass"],'app'=>"00-00");
//string json para el envio

//$fields_string=json_encode($data);
$url=URL_session;
$fields_string='user='.urlencode($_POST["user"]).'&password='.urlencode($_POST["pass"]).'&app='.urlencode("00-00");

//conexion con el servidor para la activacion de la cuenta
$ch = curl_init();

//no se por qué funciona esto, pero funciona
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POST, count($fields_string));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json"));
//execute post
$result = curl_exec($ch);

$jsonphp = json_decode($result,true,2048); 
curl_close($ch);

if(isset($jsonphp["token"])){ //todo ha salido bien
	setcookie("acrsession", $jsonphp["token"], time()+60*60*24, "/");	//renovar caducicdad de la cookie
  	$_SESSION["username"] = $jsonphp['name'];
	$_SESSION["nick"] = $jsonphp['nick'];
	$_SESSION["id"] = $jsonphp['id'];
	$_SESSION["rol"] = $jsonphp['role'];
	$_SESSION["token"] = $jsonphp['token'];
	/*echo "<pre>";
	var_dump($_SESSION);
	var_dump($_COOKIE);
	echo "</pre>";*/
	//header ("Location: index.php");
} 
else{ //ha habido un error
   header ("Location: index.php?notificacion=errorLogin");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$url=URL_user . $_SESSION["id"];

//conexion con el servidor para la activacion de la cuenta
$ch = curl_init();

//no se por qué funciona esto, pero funciona
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json"));
curl_setopt($ch, CURLOPT_COOKIE, 'acrsession='. $_SESSION['token']); 
//execute post
$result = curl_exec($ch);

$jsonphp = json_decode($result,true,2048); 
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
htmlspecialchars($result);
if ($httpCode == 200){
	// Make a new GeSHi object, with the source, language and path set
	if (isset($jsonphp['accessList'][0]))
		$_SESSION["permisoMiCodigo"] = true;
	else
		$_SESSION["permisoMiCodigo"] = false;
		
	if (isset($jsonphp['accessList'][1]))
		$_SESSION["permisoTodoCodigo"] = true;
	else
		$_SESSION["permisoTodoCodigo"] = false;

	if (isset($_POST["page"])){
		list ($a, $pagina) = explode('/', $_POST["page"]);
		echo $pagina;
	}
	
	$pos = strpos($_POST["page"], "notificacion");

	// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
	// porque la posición de 'a' está en el 1° (primer) caracter.
	if ($pos === false)
		header ("Location: " . $_POST["page"]);
	else
		header ("Location: index.php");
	echo $_POST["page"];
} 
else{ //ha habido un error
	header ("Location: index.php?notificacion=errorLogin");
}
?>
