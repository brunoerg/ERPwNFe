<?php
class Bootstrap {
	function __construct() {


		/*
		 *
		 * var1 = Pagina
		 * var2 = Funcao
		 * var3 = metodo no controller na pagina
		 *
		 *
		 * */




		//print_r($var);


		$class = $_GET ["var1"] . "Controller";
		// chamando classes

		if ($class=="Controller") {
			$class="IndexController";
		}

		if(file_exists("app/controller/$class.php")) {
			$controller = new $class ( );
			$controller->index();
		}else {
			header("Location: ".URL."Error/2/".$_GET["var1"]);
		}

		


			


	}
}