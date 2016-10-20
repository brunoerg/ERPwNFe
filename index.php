<?php
session_start();
ob_start();
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 0);
error_reporting(0);
ini_set("track_errors","0");

include "app/config/paths.php"; // CAMINHOS E URLS DO SISTEMA
include "app/config/database.php"; // CONSTANTES DE CONFIGURACAO DO DB
include "app/config/info.php"; // CONSTANTES DE INFORMACOES DO SISTEMA
include "app/autoload.php"; // AUTO LOAD DAS CLASSES
// SE NAO TIVER A VARIAVEL GET var1 ( FOR SÓ A URL ) REDIRECIONA PARA A INDEX
if (!$_GET ["var1"]) {
echo "<script>
    	window.location = 'Index';
    </script>";
}

/// SE NAO FOR LOGIN VERIFICA SE ESTA LOGADO
if ($_GET["var1"]!="Login") {

		$verifica = new Verifica();
		if($verifica->ok()){
			$app = new Bootstrap();
		}

	}else{
		$app = new Bootstrap();
	}


