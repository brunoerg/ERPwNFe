<?php
ob_start();

ini_set("display_errors", "Off");

ini_set("allow_url_fopen", "On");

date_default_timezone_set('America/Sao_Paulo');
//Constantes abaixo offline
/*
define('URL','http://'.$_SERVER['SERVER_NAME'].':8888/Way/');
define('Folder','http://'.$_SERVER['SERVER_NAME'].':8888/Way/app/public/');
*/

//Constantes abaixo Online
define('URL','http://'.$_SERVER['SERVER_NAME'].'/');
define('Folder','http://'.$_SERVER['SERVER_NAME'].'/app/public/');
$subdominio = explode(".", $_SERVER['SERVER_NAME']);
define('SUB',$subdominio[0]);
