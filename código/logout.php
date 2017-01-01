<?php
require_once('./Urls.php'); 
require_once('inc/comun.php');

$ch=curl_init();

$url=URL_session.$_COOKIE["acrsession"];
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result=curl_exec($ch);

curl_close($ch);

setcookie("acrsession",$_SESSION["token"],time()-60*60*24,"/");
/*echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";*/
session_destroy();
/*echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";
unset($_COOKIE["acrsession"] );
echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";*/
/*
unset($_SESSION["username"] );
unset($_SESSION["nick"]);
unset($_SESSION["id"] );
unset($_SESSION["rol"] );

$_SESSION["username"] = null;
$_SESSION["nick"] = null;
$_SESSION["id"] = null;
$_SESSION["rol"] = null;
*/
header ("Location: index.php");
?>