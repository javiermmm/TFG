<?php
require_once('./Urls.php'); 

if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
	setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	

extract($_POST);
$file=$_FILES['file']['tmp_name'];

// COMPROBAR QUE EXISTEN LAS VARIABLES ANTES DE COGERLAS isset($_POST["campo"]);
$code="";

if(($file !="") && $_FILES['file']['size'] < 2*1024*1024){
	$code=file_get_contents($file);
}else{
	$code=$quick;
}

$code = utf8_encode($code);
$data=array('language'=>$language,'code'=>$code,'comment'=>$comentario);
$datajson=json_encode($data);
$url=URL_submisssions_problem.$idProblema;

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_COOKIE, 'acrsession='.$_COOKIE["acrsession"]);
curl_setopt($ch,CURLOPT_POST, count($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch,CURLOPT_POSTFIELDS, $datajson);
curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode != 200){
	header ("Location: index.php?notificacion=errorEnvio");
}else{
	header ("Location: ultimosEnviosUsuario.php");
}

?>