<?php
/** urls de los servicios web por si en un futuro son cambiadas*/

require_once("./Url_base.php");

define("URL_submisssion",URL_base . "ws/submission/");
//submission = http://acr.programame.com/ws/submission/ 

define("URL_submisssions_problem",URL_base . "ws/currentuser/submissions/problem/");
//submission_problema= http://acr.programame.com/ws/currentuser/submissions/problem/

define("URL_country",URL_base . "ws/country/");
//paises = http://acr.programame.com/ws/country/

define("URL_institution",URL_base . "ws/institution/country/");
//instituciones = http://acr.programame.com/ws/institution/country/

define("URL_user_activation",URL_base . "ws/user/add?url=".urlencode(URL_base . "activateRegister.php?id={userId}&key={key}"));
//añade_user_activacion= "http://acr.programame.com/ws/user/add?url=".urlencode("http://acr.programame.com/activateRegister.php?id={userId}&key={key}")"

define("URL_volumenes",URL_base . "ws/volume/");
//volumenes = http://acr.programame.com/ws/volume/

define("URL_session",URL_base . "ws/session/");
//sesion = http://acr.programame.com/ws/session/

define("URL_problem",URL_base . "ws/problem/");
//problema = http://acr.programame.com/ws/problem/

define("URL_user",URL_base . "ws/user/");
//usuario = http://acr.programame.com/ws/user/
?>