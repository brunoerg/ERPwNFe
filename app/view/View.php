<?php
class View {
	function __construct() {

		$this->erro = "";
	}

	public function render($file, $noincludes = false) {



		if (file_exists("app/view/$file.php")) {
			if ($noincludes == true) {
				include "app/view/$file.php";
			} else {
				if($_GET["var1"]=="Error" || $_GET["var1"]=="Login" || $_GET["var2"]=="Post" ){
					
					
					include "app/view/$file.php";
				}else {
					include "app/view/header.php";
					include "app/view/menu.php";
					include "app/view/right.php";
					include "app/view/$file.php";
					include "app/view/footer.php";
				}
			}
		}else {
			header("Location: ".URL."Error/2/".$_GET["var1"]);
		}


		

	}
}