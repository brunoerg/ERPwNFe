<?php

// ADICIONAR OPCAO DE HEADER EM EMAIL
ini_set("mail.add_x_header", 1);


// MOSTRAR ERROS -> DEIXAR ON APENAS PARA DEBUG
ini_set("display_errors", "Off");

// ATIVA URL FILE OPEN
ini_set("allow_url_fopen", "On");


// DEFINE CARACTERS DEFAULTS
 ini_set('default_charset','UTF-8');
// HEADER DE LEITURA DE CARACTERS
 header("Content-Type: text/html; charset=UTF-8",true);

/// DEFINE CONSTANTES DE INFORMACOES DO SISTEMA
define('VERSAO',5); /// VERSAO DO SISTEMA
define('ALFA',""); // SISTEMA ALFA - > define('ALFA',"ALFA");
define('BETA'," BETA"); // SISTEMA BETA - > define('BETA',"BETA");
define('UPGRADE',""); // NUMERO DE UPGRADS 5.x <- ( DEIXAR VAZIO PARA VERSOES BETA E ALFA)
define('ERROS', ""); // NUMERO DE ERROS ARRUMADOS 5.0.x <- ( DEIXAR VAZIO PARA VERSOES BETA E ALFA)


/// STRING PARA CRIPTOGRAFICA NO SISTEMA, 
//A STRING É ADICIONADA A OUTRA STRING E FEITA A CRIPTOGRAFICA COM MD5
define('CRIPT',''); 