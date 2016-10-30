<?php
class LoginController extends Controller {
	function __construct() {
		
		parent::__construct ();
		
		if (isset($_GET["var2"])) {
			if ($_GET["var2"]=="Logout") {
				$this->logout();
			}

		}

	}

	function index() {
		$this->view->info = "";


		if (isset($_POST["login"])) {

			$this->login();

		}

		$this->view->render ( 'login/index' );
	}


	function login(){

		$this->login = $_POST["login"];
		$this->senha = md5($_POST["password"].CRIPT);

		

		$sql = mysql_query("SELECT * FROM  `login` WHERE login='".$this->login."'") or die(mysql_error());
		while($linha = mysql_fetch_array($sql)){
			$id = $linha['id'];
			$usuario = $linha['nome'];
			$login_db = $linha['login'];
			$senha_db = $linha['senha'];
		}


		//$this->view->info = $login_db." --d-  ".$senha_db;

		if($this->login!=$login_db){

			$this->view->info = " - Login $login_db Errado!";
		}else{
			if($senha_db!=$this->senha){
				$this->view->info = " - Senha Errada!";
			}else{
			        ob_start();
				session_start();
				setcookie("login_usuario", $login_db, time()+60*60*24*30);
				setcookie("senha_usuario", $senha_db, time()+60*60*24*30);
				setcookie("Logado", true, time()+60*60*24*30);
				setcookie("usuario", $usuario, time()+60*60*24*30);
				$_SESSION["id_usuario"] = $id;
				$_SESSION["login_usuario"] = $login_db;
				$_SESSION["senha_usuario"] = $senha_db;
				$this->Log("O usuario entrou.");
				if ($_SESSION["returnPage"]) {
					header("Location: ".$_SESSION["returnPage"]);	
				}else{
					header("Location: ".URL."Index");	
				}
				
			}
		}

	} // FECHA FUNCAO LOGAR


	///////////////////////////////////////////////////////////////////////////////////////////////////////

	function logout(){

		setcookie("Logado", false, time()-60,"/");
		setcookie("login_usuario", false, time()-60,"/");
		setcookie("senha_usuario", false, time()-60,"/");
		setcookie("usuario", false, time()-60,"/");
		
		session_start();
		$this->Log("O usu�rio saiu.");
		unset($_SESSION["id_usuario"]);
		unset($_SESSION["login_usuario"]);
		unset($_SESSION["senha_usuario"]);

		


		echo"<script type='text/javascript'>
		window.location = '".URL."Login';
		</script>";
	} // FECHA FUNCAO SAIR


	///////////////////////////////////////////////////////////////////////////////////////////////////////



}