<?php
require_once('./Urls.php'); 
require_once('./inc/comun.php'); 

if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
	setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	

if (isset($_POST["search-text"]))
	$idProblema = $_POST["search-text"];

$url=URL_problem.$idProblema;

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($ch);
$jsonphp = json_decode($result,true,2048); 
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//var_dump($result);
curl_close($ch);

if ($httpCode != 200){
	//echo ("MALO");
	header ("Location: index.php?notificacion=errorBuscar");
}else{
	//echo("CODIGO 200");
	header ("Location: enunciado.php?num=".$idProblema);
}

?>
