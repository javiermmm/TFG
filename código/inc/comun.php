<?php
/*
$config = array();

$config['cookie_timeout'] = 60 * 60 * 1; // 1h en segundos
$config['cookie_name'] = 'acrsession';


 * inicializa la sesion (incorpora la cookie a la respuesta,
 * y si la peticion tenia cookie, almacena sus valores en 
 * el array superglobal _SESSION) 
 */
//session_set_cookie_params($config['cookie_timeout'], $config['cookie_path']);
//session_name($config['cookie_name']);
session_name("session_cookie");
session_start();
/*if ( ! isset($_SESSION['username'])) {
	// inicializa una sesion vacia	
	$_SESSION['username'] = null;
	//$_SESSION['role'] = null;
}
*/

?>