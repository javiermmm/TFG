<?php
//include_once("webServices.conf");
require_once ("Urls.php");


//check todos los parametros existen
if(!isset($_GET["id"]) || !isset($_GET["key"]))
  header ("Location: errorLogin.php");


$key=$_GET["key"];
$id=$_GET["id"];


$data=array('key'=>$key,'id'=>$id);
$url=URL_user. "activation/".$id."/".$key;

//string json para el envio
$fields_string="{";
foreach($data as $key=>$value) { 
    $fields_string .= '"'.$key.'":"'.$value.'",'; //concatenamos valores array
}

$fields_string = substr($fields_string, 0, -1); //eliminamos la ultima coma
//trim($fields_string, ',');
$fields_string.="}";

$fields_string=json_encode($fields_string);

//conexion con el servidor para la activacion de la cuenta
$ch = curl_init();


//no se por qué funciona esto, pero funciona
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields_string));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));

//execute post
$result = curl_exec($ch);

curl_close($ch);


echo $result;

header ("Location: index.php?notificacion=Activacion");

?>