<?php

function __autoload($classe) {
	
	if (strstr ( $classe, "View" )) {
		
		// inclui a classe da pasta view se ela tiver view no nome
		if (file_exists ( "app/view/$classe.php" )) {
			
			include "app/view/$classe.php";
		
		} else {
			$error = new ErrorController ( );
			return false;
		}
	
	} elseif (strstr ( $classe, "Model" )) {
		
		// inclui a classe da pasta model se ela tiver model no nome
		

		if (file_exists ( "app/model/$classe.php" )) {
			
			include "app/model/$classe.php";
		
		} else {
			$error = new ErrorController ( );
			return false;
		}
	
	} elseif (strstr ( $classe, "Controller" )) {
		
		// inclui a classe da pasta controller se ela tiver controller no nome
		

		if (file_exists ( "app/controller/$classe.php" )) {
			
			include "app/controller/$classe.php";
		
		} else {
			$error = new ErrorController ( );
			return false;
		}
	
	} else {
		
		// inclui a classe da pasta lib se ela só tiver o nome simples
		if (file_exists ( "app/lib/$classe.php" )) {
			
			include "app/lib/$classe.php";
		
		} else {
			$error = new ErrorController ( );
			return false;
		}
	}

}