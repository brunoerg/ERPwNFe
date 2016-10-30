<?php

class Verifica extends Controller{

	function __construct(){


		parent::__construct();
		if ($_COOKIE["Logado"]) {


			if($_COOKIE["login_usuario"]){

				$login_usuario = $_COOKIE["login_usuario"];
				$senha_usuario = $_COOKIE["senha_usuario"];

				$sql = mysql_query("SELECT * FROM `login` WHERE login = '".$login_usuario."'") or die(mysql_error());

				while($linha = mysql_fetch_array($sql)){
					$senha_db = $linha['senha'];

				}

				if($senha_db != $senha_usuario){

					$this->view->info = " - Senha Errada!";


					unset($_COOKIE["login_usuario"]);
					unset($_COOKIE["senha_usuario"]);

					$msg = "Usuario desconhecido tentou acessar o sistema com a senha incorreta! Senha Tentada: $senha_usuario";
					$this->Log($msg);

					$this->ok=false;
					header("Location: ".URL."Login");
				}else{
					$this->ok=true;
				}

			}else{
				$msg = "Usuario desconhecido tentou acessar o sistema com o login incorreto! Login Tentado: $login_usuario";
				$this->Log($msg);
				$this->ok=false;
				header("Location: ".URL."Login");

			}
		}else{
			$msg = "Usuario desconhecido tentou acessar o sistema sem a verificação necessária!";
			$this->Log($msg);
			$this->ok=false;
			echo "<script>
    	window.location = 'Login';
    </script>";

		}
		
	}
	
	
	public function ok(){
		return $this->ok;
	}



	protected function Log($msg) {

		
		$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$data = date("d-m-y");
		$hora = date("H:i:s");
		$usuario = "Usuario Desconhecido";

		$ip = $_SERVER["REMOTE_ADDR"];

		//pasta
		$pasta = "app/public/logs/";

		//Nome do arquivo:
		$arquivo = $pasta . "Log_$data.txt";

		//Texto a ser impresso no log:
		$texto = "\n[$hora][$usuario][$ip][$url]> $msg";

		$manipular = fopen("$arquivo", "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);

	}
}