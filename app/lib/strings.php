<?php
class strings {

	function preparar($texto) {

		$texto = str_replace ( "'", "\'", $texto );
		$texto = str_replace ( '"', "\"", $texto );
		$texto = trim($texto);
		$texto = htmlspecialchars ( $texto );
		return $texto;
	}

	function converter_acentos($texto) {
		$texto = htmlspecialchars ( $texto );
		return $texto;
	}

	function reverter_acentos($texto) {
		$texto = htmlspecialchars_decode($texto);

		return $texto;
	}

	function convertAcentosNormais($texto){
		$trocarIsso = array('&ccedil;','&atilde;','&otilde;','&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&agrave;','&egrave;','&igrave;','&ograve;','&ugrave;','&Ccedil;','&Atilde;','&Otilde;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Agrave;','&Egrave;','&Igrave;','&Ograve;','&Ugrave;');
		$porIsso = array('ç','ã','õ','á','é','í','ó','ú','à','è','ì','ò','ù','Ç','Ã','Õ','Á','É','Í','Ó','Ú','À','È','Ì','Ò','Ù');
		$texto = str_replace($trocarIsso, $porIsso, $texto);
		return $texto;
	}
	function tirar_acentos($texto) {
		$trocarIsso = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','O','�','�','�','�',);
		$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y',);
		$titletext = str_replace($trocarIsso, $porIsso, $texto);
		return $texto;
	}
	function converter_espacos($texto, $sinal) {
		$texto = str_replace ( " ", $sinal, $texto );
		return $texto;
	}
	function reverter_espacos($texto, $sinal) {
		$texto = str_replace ( $sinal, " ", $texto );
		return $texto;
	}

}